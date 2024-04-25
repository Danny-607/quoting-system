<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
        
    $user = auth()->user();  // Assuming the user is authenticated

    // Fetch unapproved quotes with their services
    $unapprovedQuotes = Quote::with(['services'])
                             ->where('user_id', $user->id)
                             ->where('status', 'unapproved')
                             ->get();

    // Fetch approved quotes with their services
    $approvedQuotes = Quote::with(['services'])
                           ->where('user_id', $user->id)
                           ->where('status', 'approved')
                           ->get();

    return view('customer.index', compact('unapprovedQuotes', 'approvedQuotes'));
}
    }

