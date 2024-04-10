<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\RunningCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RunningCostsController extends Controller
{

    public function index(){
        $user = Auth::user();
        $runningCosts = RunningCost::all();
        $categories = Category::all();
        if ($user) {
            $username = $user->name;
            return view('runningcosts.index', compact('username', 'categories', 'runningCosts'));
        } else {
            return redirect()->route('login');
        }

    }
    public function create(){
        $user = Auth::user();
        $categories = Category::all();
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
            'category' => 'required|exists:categories,id',
            'repeating' => 'nullable|boolean',
        ]);
        $runningCost = new RunningCost();
        $runningCost->name = $validatedData['name'];
        $runningCost->cost = $validatedData['cost'];
        $runningCost->date_incurred = $validatedData['date_incurred'];
        $runningCost->category_id = $validatedData['category'];
        $runningCost->repeating = $request->has('repeating');
        $runningCost->save();


        return redirect()->route('runningcosts.index')->with('success', 'Running cost added successfully.');
    }
    public function edit($id){
        $user = Auth::user();
        $runningCost = RunningCost::findOrFail($id);
        $categories = Category::all();
        if ($user) {
            $username = $user->name;
            return view('runningcosts.edit', compact('username', 'categories', 'runningCost'));
        } else {
            return redirect()->route('login');
        }

    }
    public function update($id, Request $request){
        
        $runningCost = RunningCost::findOrFail($id);
        if ($request->has('repeating')){
            $runningCost->repeating = 1;
        } else{
            $runningCost->repeating = 0;
        }
        $request->validate([
            'name' => 'required|string',
            'cost' => 'required|numeric',
            'date_incurred' => 'required|date',
            'category' => 'required|exists:categories,id',
            'repeating' => 'boolean',
        ]);

        $runningCost->category_id = $request->category;
        $runningCost->update($request->except('category'));

        return redirect()->route('runningcosts.index')->with('success', 'Running cost updated successfully.');
    }

    public function destroy($id)
    {
        $runningCost = RunningCost::findOrFail($id);
        $runningCost->delete();

        return redirect()->route('runningcosts.index')->with('success', 'Running cost deleted successfully.');
    }
}
