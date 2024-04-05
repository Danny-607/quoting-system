<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Service;
use App\Models\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class QuotesController extends Controller
{

    public function index(){
        $services = Service::all();
        $user = Auth::user();
        $quotes = Quote::with('services', 'user')->get();
        if ($user) {
            $username = $user->name;
            return view('quotes.index', compact('quotes', 'username'));
        } else {
            return redirect()->route('login');
        }
    }
    
    public function create()
    {
        $services = Service::all();
        $user = Auth::user();
        if ($user) {
            $username = $user->name;
            return view('quotes.create', ['username' => $username, 'services' => $services]);
        } else {
            return redirect()->route('login');
        }
    }
    public function store(Request $request){
        $request->validate([
            'services' => [
                'required',
                'array',
                // Ensure at least one service is selected
                'min:1', 
                // Validate that service IDs exist in the database
                Rule::exists('services', 'id'), 
            ],
            // Ensure no duplicate service IDs
            'services.*' => 'distinct', 
            'description' => 'required|string',
        ]);

        $selectedServices = $request->input('services');

        // Retrieve the prices of the selected services
        $totalPrice = Service::whereIn('id', $selectedServices)->sum('price');

        $user = Auth::user();
        $quote = $user->quotes()->create([
            'description' => $request->description,
            'preliminary_price' => $totalPrice,
            'approved' => 'no'
        ]);

        foreach ($request->services as $serviceId) {
            QuoteService::create([
                'quote_id' => $quote->id,
                'service_id' => $serviceId,
            ]);
        }

    }

    public function accept(Quote $quote)
    {
        $quote->update(['approved' => 'yes']);
        return redirect()->route('quotes.index');
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();
        return redirect()->route('quotes.index');
    }
    
}
