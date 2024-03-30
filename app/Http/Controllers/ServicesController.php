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
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required|decimal:0,2',
        ]);

        $newService = Service::create($data);

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
            'price' => 'required|decimal:0,2',
        ]);

        $service->update($data);

        return redirect(route('services.index'))->with('success', 'Service updated successfully');
    }
}
