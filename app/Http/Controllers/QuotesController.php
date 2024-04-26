<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Invoice;
use App\Models\Service;
use App\Mail\InvoiceCreated;
use App\Models\QuoteService;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class QuotesController extends Controller
{
    // Method to display a list of all quotes with related service and user details.
    public function index(){
        $services = Service::all(); // Retrieve all services.
        $user = Auth::user(); // Get the currently authenticated user.
        $quotes = Quote::with('services', 'user')->get(); // Retrieve all quotes with eager loaded services and user.

        if ($user) { // Check if user is authenticated.
            $name = $user->first_name; // Extract the first name of the user.
            return view('quotes.index', compact('quotes', 'name')); // Return the quotes index view with quotes and user name.
        } else {
            return redirect()->route('login'); // Redirect to login page if user is not authenticated.
        }
    }
    
    // Method to display the form for creating a new quote.
    public function create()
    {
        $services = Service::all(); // Retrieve all services.
        $categories = ServiceCategory::with('services')->get(); // Retrieve all service categories and their related services.
        $user = Auth::user(); // Get the currently authenticated user.

        if ($user) { // Check if user is authenticated.
            $name = $user->first_name; // Extract the first name of the user.
            return view('quotes.create', compact('name', 'services', 'categories')); // Return the create quote view with services and categories.
        } else {
            return redirect()->route('login'); // Redirect to login page if user is not authenticated.
        }
    }

    // Method to handle the storage of a newly created quote.
    public function store(Request $request){
        // Validate incoming request data.
        $request->validate([
            'services' => [
                'required', 'array', 'min:1', // Ensure at least one service is selected.
                Rule::exists('services', 'id'), // Validate that the selected service IDs exist in the database.
            ],
            'services.*' => 'distinct', // Ensure no duplicate service IDs.
            'description' => 'required|string', // Ensure description is provided.
        ]);

        $selectedServices = $request->input('services'); // Retrieve selected service IDs from request.
        $totalPrice = Service::whereIn('id', $selectedServices)->sum('price'); // Calculate the total price for the selected services.

        $user = Auth::user(); // Get the currently authenticated user.
        $quote = $user->quotes()->create([ // Create a new quote associated with the user.
            'description' => $request->description,
            'preliminary_price' => $totalPrice,
            'status' => 'unapproved'
        ]);

        foreach ($request->services as $serviceId) { // Create records linking the quote to selected services.
            QuoteService::create([
                'quote_id' => $quote->id,
                'service_id' => $serviceId,
            ]);
        }
        
        // Redirect based on user role after quote creation.
        if ($user->hasRole('customer')) {
            return redirect()->route('home')->with('success', 'Quote submitted successfully!');
        } else {
            return redirect()->route('quotes.index')->with('success', 'Quote created and submitted for approval!');
        }
    }

    // Method to display the form for editing an existing quote.
    public function edit($id)
    {
        $quote = Quote::findOrFail($id); // Retrieve the quote or fail if not found.
        $name = Auth::user()->first_name; // Get the first name of the authenticated user.
        return view('quotes.edit', compact('quote', 'name')); // Return the edit quote view.
    }

    // Method to handle the update of a quote's details.
    public function update(Request $request, $id)
    {
        $quote = Quote::findOrFail($id); // Retrieve the quote or fail if not found.
        
        // Update the quote with the new data from the request.
        $quote->update([
            'description' => $request->description,
            'preliminary_price' => $request->preliminary_price,
            'status' => $request->status,
        ]);

        return redirect()->route('quotes.index')->with('success', 'Quote updated successfully!'); // Redirect with a success message.
    }

    // Method to accept a quote, create an invoice, and notify the user via email.
    public function accept(Quote $quote)
    {
        $quote->update(['status' => 'approved']); // Update quote status to approved.
        $invoice = Invoice::create([ // Create a new invoice based on the quote.
            'quote_id' => $quote->id,
            'amount' => $quote->preliminary_price,
        ]);
        $invoice->load('quote.services'); // Eager load related services.
        
        // Send an invoice email to the quote's user.
        Mail::to($quote->user->email)->send(new InvoiceCreated($invoice));
        
        return redirect()->route('projects.create', ['quote' => $quote->id]); // Redirect to create a project based on the quote.
    }

    // Method to delete a quote from the database.
    public function destroy(Quote $quote)
    {
        $quote->delete(); // Delete the quote.
        return redirect()->route('quotes.index'); // Redirect back to the quotes index.
    }
}