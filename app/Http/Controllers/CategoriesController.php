<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\RunningCostCategory;

class CategoriesController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        
        if ($user) {
            $name = $user->first_name;
            return view('categories.create', compact('name'));
        } else {
            return redirect()->route('login');
        }
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:service,running_cost',
        ]);

        if ($request->type === 'service') {
            ServiceCategory::create(['name' => $request->name]);
            return redirect()->route('services.index')->with('success', 'Category created successfully.');
        } elseif ($request->type === 'running_cost') {
            RunningCostCategory::create(['name' => $request->name]);
            return redirect()->route('runningcosts.index')->with('success', 'Category created successfully.');

        }

        
    }
}
