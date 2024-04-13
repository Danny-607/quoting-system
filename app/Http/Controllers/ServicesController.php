<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{

    public function index(){
        $services = Service::all();
        $user = Auth::user();

        if ($user){
            $username = $user->name;
            return view('services.index', ['username'=> $username, 'services' => $services]);
        } else{
            return redirect()->route('login');
        }
        
    }
    public function create(){
        return view('services.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'cost' => 'required|decimal:0,2',
            'price' => 'required|decimal:0,2',
        ]);
        $profit = $validated['price'] - $validated['cost'];
        $service = new Service();
        
        $service->name = $validated['name'];
        $service->cost = $validated['cost'];
        $service->price = $validated['price'];
        $service->profit = $profit;
        $service->save();

        

        return redirect(route('services.index'));
    }

    public function edit(Service $service){
        $user = Auth::user();

        if ($user){
            $username = $user->name;
            return view('services.edit', ['username'=> $username, 'service' => $service]);
        } else{
            return redirect()->route('login');
        }

    }
    public function update(Service $service, Request $request){
        $data = $request->validate([
            'name' => 'required',
            'cost' => 'required|decimal:0,2',
            'price' => 'required|decimal:0,2',
        ]);

        $service->update($data);

        return redirect(route('services.index'))->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service){
        $service->delete();

        return redirect(route('services.index'))->with('success', 'Service deleted successfully');

    }
}
