<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $services = Service::with('serviceCategory')->get();
        return view('services.index', ['services' => $services, 'name' => $this->user->first_name]);
    }

    public function create()
    {
        $categories = ServiceCategory::all();
        return view('services.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:service_categories,id',
        ]);

        $serviceData = $request->only(['name', 'cost', 'price']);
        $serviceData['profit'] = $request->price - $request->cost;
        $serviceData['service_category_id'] = $request->category_id;

        Service::create($serviceData);

        return redirect()->route('services.index')->with('success', 'Service added successfully');
    }

    public function edit(Service $service)
    {
        $categories = ServiceCategory::all();
        return view('services.edit', ['service' => $service, 'categories' => $categories, 'name' => $this->user->name]);
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:service_categories,id',
        ]);

        $serviceData = $request->only(['name', 'cost', 'price']);
        $serviceData['profit'] = $request->price - $request->cost;
        $serviceData['service_category_id'] = $request->category_id;

        $service->update($serviceData);

        return redirect()->route('services.index')->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully');
    }
}