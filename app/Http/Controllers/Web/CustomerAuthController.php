<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Helpers\EncryptDecrypt;
use App\Traits\ConsumeExternalService;
use App\Models\User;
use App\Models\booking;
use App\Models\Verify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;



class CustomerAuthController extends Controller
{
    use ConsumeExternalService;

// ------------------------------------------SIGNUP--------------------------------------


public function booking(Request $request)
{
    $booked_dates = Booking::where('booking_type', 'Full Day')
                    ->pluck('booking_date')
                    ->toArray();
    
    $booked_times = Booking::whereIn('booking_type', ['Custom', 'Half Day'])
                    ->get(['booking_date', 'booking_type', 'booking_slot', 'booking_from', 'booking_to'])
                    ->groupBy('booking_date');
    
    return view('web.booking', compact('booked_dates', 'booked_times'));
}





public function booking_add(Request $request)
{
    $bookingDate = $request->booking_date;
    $bookingType = $request->booking_type;
    $bookingSlot = $request->booking_slot;
    $bookingFrom = $request->booking_from;
    $bookingTo = $request->booking_to;

    $fullDayBooked = Booking::where('booking_date', $bookingDate)
                            ->where('booking_type', 'Full Day')
                            ->exists();

    if ($fullDayBooked) {
        return redirect()->back()->with('error', 'This date is already fully booked.');
    }


    $customSlotBooked = Booking::where('booking_date', $bookingDate)
                               ->where('booking_type', 'Custom')
                               ->exists();

    if (($bookingType === 'Half Day' || $bookingType === 'Full Day') && $customSlotBooked) {
        return redirect()->back()->with('error', 'Cannot book Half Day or Full Day as Custom Time Slots are already booked for this date.');
    }


    $halfDayBooked = Booking::where('booking_date', $bookingDate)
                            ->where('booking_type', 'Half Day')
                            ->whereIn('booking_slot', ['First Half', 'Second Half'])
                            ->pluck('booking_slot')
                            ->toArray();

    
    if ($bookingType === 'Half Day' && in_array($bookingSlot, $halfDayBooked)) {
        return redirect()->back()->with('error', "Cannot book $bookingSlot as it is already booked for this date.");
    }

    
    if ($bookingType === 'Full Day' && count($halfDayBooked) > 0) {
        return redirect()->back()->with('error', 'Cannot book Full Day as a Half Day slot is already booked for this date.');
    }

    
    if ($bookingType === 'Custom') {
        foreach ($halfDayBooked as $slot) {
            if ($slot === 'First Half' && ($bookingFrom < '12:00' && $bookingTo > '00:00')) {
                return redirect()->back()->with('error', 'Cannot book Custom time as First Half is already booked.');
            }
            if ($slot === 'Second Half' && ($bookingFrom >= '12:00' && $bookingTo <= '23:59')) {
                return redirect()->back()->with('error', 'Cannot book Custom time as Second Half is already booked.');
            }
        }
    }

    if ($bookingType === 'Custom') {
        $bookingSlot = null;  
    }
    if ($bookingType === 'Full Day') {
        $bookingSlot = null; 
    }
    $user_data = $request->session()->get('User_data');
    $user_id = $user_data->id; 
    
    Booking::create([
        'customer_id'  => $user_id,
        'customer_name'  => $request->customer_name,
        'customer_email' => $request->customer_email,
        'booking_date'   => $bookingDate,
        'booking_type'   => $bookingType,
        'booking_slot'   => $bookingSlot,
        'booking_from'   => $bookingFrom,
        'booking_to'     => $bookingTo,
    ]);

    return redirect()->route('customer.customer.home')->with('success', 'Booking successfully created.');
}



    

    public function signupuser(Request $request)
    {
        return view('web.auth.signup');
    }


    public function signupPost(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $existingUser = DB::table('tbl_user')->where('email', $request->email)->first();
    
        if ($existingUser) {
            return redirect()->back()->with('error', 'This email is already registered.');
        }
    
        $post_data = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'role' => "Customer"
        );
    
        $otp = rand(1000, 9999);
        
        $verify_post_data = array(
            'email' => $request->email,
            'otp' => $otp
        );
        
        $user_id = DB::table('tbl_user')->insertGetId($post_data);
    
        if ($user_id) {
            
            $user_data = DB::table('tbl_user')->where('id', $user_id)->first();
            $email = $user_data->email;
            $request->session()->put('User_data', $user_data);
    
            Mail::send('web.auth.otp', ['otp' => $otp], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Your OTP Code');
            });
    
            DB::table('tbl_verify')->insertGetId($verify_post_data);
    
            return redirect()->route('customer.verify');
        } else {
            return redirect()->back()->with('error', 'Registration failed, please try again.');
        }
    }
    

// ---------------------------------------LOGIN-----------------------------------------


   public function loginuser(Request $request)
    {
        return view('web.auth.login');
    }


  
    public function loginPost(Request $request)
    {
        
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    

        $email = $request->email;
        $password = $request->password;
    
        $customer = DB::table('tbl_user')->where('email', $email)->first();
    
        if ($customer) {
            
            if (Hash::check($password, $customer->password)) {

                if ($customer->role == 'Customer') {
                    $request->session()->put('User_data', $customer);
    
                return redirect()->route('customer.customer.home')->with('success', 'Login successful');
                } else {
                    return redirect()->back()->with('error', 'You are not allowed to login from here');
                }
                
            } else {
                return redirect()->back()->with('error', 'Invalid password');
            }
        } else {
            return redirect()->back()->with('error', 'User not found');
        }
    }






public function verify(Request $request)
{
    return view('web.auth.verify');
}


public function verify_post(Request $request)
{
    
    $request->validate([
        'email' => 'required',
        'otp' => 'required',
    ]);

    
    $email = $request->email;
    $otp = $request->otp;

    
    $customer = DB::table('tbl_verify')->where('email', $email)->first();
    
    if ($customer && $customer->otp == $otp) {
        $request->session()->put('login_user_data', $customer);
        $userdata = DB::table('tbl_user')->where('email', $email)->first();
        DB::table('tbl_verify')->where('email', $email)->delete();
        return redirect()->route('customer.customer.home')->with('success', 'Login successful');
    } else {
    
        return redirect()->back()->with('error', 'Invalid email or OTP');
    }
}


}