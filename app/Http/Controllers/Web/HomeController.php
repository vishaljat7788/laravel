<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\booking;

class HomeController extends Controller
{



public function index()
{
    return view('web.index');
}



public function home(Request $request)
{

    $user_data = $request->session()->get('User_data');
    
    if ($user_data) {
    
        $user_id = $user_data->id;



        
        $bookings = Booking::select('id', 'customer_name', 'customer_email', 'booking_date', 'booking_type', 'booking_slot', 'booking_from', 'booking_to')
            ->where('customer_id', $user_id) 
            ->orderBy('booking_date', 'asc')
            ->limit(100)
            ->get();
        return view('web.home', compact('bookings'));
    } else {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }
}

    
    
}
