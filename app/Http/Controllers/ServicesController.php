<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    // Method to display all services along with their categories.
    public function index(){
        $user = Auth::user(); // Get the currently authenticated user.
        $name = $user->first_name; // Retrieve the first name of the user.
        $services = Service::with('serviceCategory')->get(); // Retrieve all services with their associated categories.
        return view('services.index', compact('services', 'name')); // Return the index view with services and user name.
    }

    // Show the form for creating a new service.
    public function create(){
        $user = Auth::user(); // Get the currently authenticated user.
        $categories = ServiceCategory::all(); // Retrieve all service categories.
        $name = $user->first_name; // Retrieve the first name of the user.
        return view('services.create', compact('categories', 'name')); // Return the create view with categories and user name.
    }

    // Handle the submission of the form for creating a new service.
    public function store(Request $request){
        // Validate the request data.
        $request->validate([
            'name' => 'required|string', // Service name must be a non-empty string.
            'cost' => 'required|numeric', // Cost must be numeric.
            'price' => 'required|numeric', // Price must be numeric.
            'category_id' => 'required|exists:service_categories,id', // Category ID must exist in the service_categories table.
        ]);

        $service = new Service($request->only(['name', 'cost', 'price'])); // Create a new service instance with specified attributes.
        $service->profit = $request->price - $request->cost; // Calculate the profit for the service.
        $service->service_category_id = $request->category_id; // Assign the service category ID.
        $service->save(); // Save the service to the database.

        return redirect(route('services.index'))->with('success', 'Service added successfully'); // Redirect to the services index with a success message.
    }

    // Show the form for editing the specified service.
    public function edit(Service $service){
        $user = Auth::user(); // Get the currently authenticated user.
        $name = $user->first_name; // Retrieve the first name of the user.
        $categories = ServiceCategory::all(); // Retrieve all service categories.
        return view('services.edit', compact('service', 'categories', 'name')); // Return the edit view with the service, categories, and user name.
    }

    // Handle the submission of the form for updating the specified service.
    public function update(Request $request, Service $service){
        // Validate the request data.
        $request->validate([
            'name' => 'required|string', // Service name must be a non-empty string.
            'cost' => 'required|numeric', // Cost must be numeric.
            'price' => 'required|numeric', // Price must be numeric.
            'category_id' => 'required|exists:service_categories,id', // Category ID must exist in the service_categories table.
        ]);

        $service->update($request->only(['name', 'cost', 'price'])); // Update the service with the specified attributes.
        $service->profit = $request->price - $request->cost; // Update the profit for the service.
        $service->service_category_id = $request->category_id; // Update the service category ID.
        $service->save(); // Save the changes to the database.

        return redirect(route('services.index'))->with('success', 'Service updated successfully'); // Redirect to the services index with a success message.
    }

    // Delete the specified service from the database.
    public function destroy(Service $service){
        $service->delete(); // Delete the service.
        return redirect(route('services.index'))->with('success', 'Service deleted successfully'); // Redirect to the services index with a success message.
    }
}