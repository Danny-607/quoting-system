<?php

namespace App\Http\Controllers;


use App\Models\RunningCost;
use Illuminate\Http\Request;
use App\Models\RunningCostCategory;
use Illuminate\Support\Facades\Auth;

class RunningCostsController extends Controller
{

    public function index(){
        $user = Auth::user();
        $runningCosts = RunningCost::with('runningCostCategory')->get();
        if ($user) {
            $username = $user->name;
            return view('runningcosts.index', compact('username', 'runningCosts'));
        } else {
            return redirect()->route('login');
        }

    }
    public function create(){
        $user = Auth::user();
        $categories = RunningCostCategory::all();
        if ($user) {
            $username = $user->name;
            return view('runningcosts.create', compact('username', 'categories'));
        } else {
            return redirect()->route('login');
        }
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string',
            'cost' => 'required|numeric',
            'date_incurred' => 'required|date',
            'category' => 'required|exists:running_cost_categories,id',  // Corrected table name
            'repeating' => 'nullable|boolean',
        ]);

        $runningCost = new RunningCost();
        $runningCost->name = $validatedData['name'];
        $runningCost->cost = $validatedData['cost'];
        $runningCost->date_incurred = $validatedData['date_incurred'];
        $runningCost->running_cost_category_id = $validatedData['category'];  // Ensure this is the correct field name
        $runningCost->repeating = $request->has('repeating');
        $runningCost->save();

        return redirect()->route('runningcosts.index')->with('success', 'Running cost added successfully!');
    }

    public function edit($id){
        $user = Auth::user();
        $runningCost = RunningCost::findOrFail($id);
        $categories = RunningCostCategory::all();
        if ($user) {
            $username = $user->name;
            return view('runningcosts.edit', compact('username', 'categories', 'runningCost'));
        } else {
            return redirect()->route('login');
        }

    }
    public function update($id, Request $request){
        
        $validatedData = $request->validate([
            'name' => 'required|string',
            'cost' => 'required|numeric',
            'date_incurred' => 'required|date',
            'category_id' => 'required|exists:running_cost_categories,id',
            'repeating' => 'nullable|boolean',
        ]);
    
        $runningCost = RunningCost::findOrFail($id);
        $runningCost->name = $validatedData['name'];
        $runningCost->cost = $validatedData['cost'];
        $runningCost->date_incurred = $validatedData['date_incurred'];
        $runningCost->running_cost_category_id = $validatedData['category_id'];
        $runningCost->repeating = $request->has('repeating') ? 1 : 0;
    
        $runningCost->save();
    
        return redirect()->route('runningcosts.index')->with('success', 'Running cost updated successfully');
    }

    public function destroy($id)
    {
        $runningCost = RunningCost::findOrFail($id);
        $runningCost->delete();

        return redirect()->route('runningcosts.index')->with('success', 'Running cost deleted successfully.');
    }
}
