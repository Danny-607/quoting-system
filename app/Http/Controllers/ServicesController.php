<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{

    public function index(){
        return view('services.index');
        
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
}
