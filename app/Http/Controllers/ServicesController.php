<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{

    public function index(){
        $user = Auth::user();
        $name = $user->first_name;
        $services = Service::with('serviceCategory')->get();
        return view('services.index', compact('services', 'name'));
    }

    public function create(){
        $categories = ServiceCategory::all();
        return view('services.create', compact('categories'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:service_categories,id',
        ]);

        $service = new Service($request->only(['name', 'cost', 'price']));
        $service->profit = $request->price - $request->cost;
        $service->service_category_id = $request->category_id;
        $service->save();

        return redirect(route('services.index'))->with('success', 'Service added successfully');
    }

    public function edit(Service $service){
        $user = Auth::user();
        $name = $user->name;
        $categories = ServiceCategory::all();
        return view('services.edit', compact('service', 'categories', 'username'));
    }

    public function update(Request $request, Service $service){
        $request->validate([
            'name' => 'required|string',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:service_categories,id',
        ]);

        $service->update($request->only(['name', 'cost', 'price']));
        $service->profit = $request->price - $request->cost;
        $service->service_category_id = $request->category_id;
        $service->save();

        return redirect(route('services.index'))->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service){
        $service->delete();
        return redirect(route('services.index'))->with('success', 'Service deleted successfully');
    }
}
