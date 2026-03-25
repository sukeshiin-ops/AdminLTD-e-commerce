<?php

namespace App\Http\Controllers;

use App\Jobs\sendEmailJob;
use App\Jobs\sendOtpJob;
use App\Jobs\SendPasswordJob;
use App\Models\Cart;
use App\Models\Otp;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {

        $user = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!$user) {
            return "Provided Input is not Proper Formate";
            abort(401);
        }


        sendEmailJob::dispatch($user);
        User::create($user);


        return redirect()->route('LoginPage');
    }


    public function login(Request $request)
    {

        $user = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!$user) {
            return "Provided Input is not Proper Formate";
            abort(401);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            abort(401, 'Unauthorized User');
        }

        if (Gate::allows('isAdmin')) {
            if (Auth::attempt($request->only('email', 'password'))) {
                return redirect()->route('dashboard.page');
            }
        }
        if (Gate::allows('isUser')) {
            if (Auth::attempt($request->only('email', 'password'))) {
                return redirect()->route('e-commerce-page');
            }
        }

        if (Gate::allows('isSeller')) {
            if (Auth::attempt($request->only('email', 'password'))) {
                return redirect()->route('e-commerce-page');
            }
        }
    }


    public function logout()
    {

        $user = Auth::user();

        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();




        return redirect()->route('LoginPage');
    }


    public function change_pass(Request $request)
    {
        $user = Auth::user();


        // dd($user->email);

        $request->validate([
            'password_current' => 'required',
            'password_new' => 'required|confirmed',
        ]);

        $currentPassword = $request->input('password_current');
        $newPassword = $request->input('password_new');
        $confirmPassword = $request->input('password_new_confirmation');




        if (!Hash::check($currentPassword, $user->password)) {

            return redirect()->route('change.password.now')->with('error', 'Password Not Match!!');
        }

        if (User::where('email', $user->email)->where(Hash::check($currentPassword, $user->password))) {

            $hashNewPassword = Hash::make($newPassword);


            $user->update([
                'password' => $hashNewPassword
            ]);

            return redirect()->route('dashboard.page');
        }
    }



    public function sendOtp(Request $request)
    {

        $request->validate([
            'email' => 'required|email'
        ]);

        $checkUserInDB = User::where('email', $request->email)->first();

        if (!$checkUserInDB) {
            return redirect()->route('ForgotPasswordPage')->with('error', 'Email Not Match!!')->with('email', $request->email);
        }

        $otp = rand(100000, 999999);

        Otp::where('email', $request->email)->delete();

        $user =  Otp::create([
            'email' => $request->input('email'),
            'otp' => $otp,
            'expires_at' => now()->addMinutes(1)
        ]);

        sendOtpJob::dispatch($user);


        return redirect()->route('ForgotPasswordPage')->with('success', 'Otp Sended Successfully!!')->with('email', $request->email);
    }


    public function verifyOtp(Request $request)
    {
        $otp =  $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4 . $request->otp5 . $request->otp6;

        $request->validate([
            'email' => 'required|email',
        ]);

        $fetchOtp = Otp::where('email', $request->email)->where('otp', $otp)->where('expires_at', '>', now())->latest()->first();

        if (!$fetchOtp) {
            return redirect()->route('ForgotPasswordPage')->with('error', 'Otp Not Match!!')->with('email', $request->email);
        }

        $fetchOtp->delete();

        return redirect()->route('ResetPasswordPage')->with('success', 'Otp Verify Successfully!!')->with('email', $request->email);
    }





    public function reset_pass(Request $request)
    {
        $request->validate([
            'password_New' => 'required',
            'email' => 'required|email'
        ]);


        $newPassword = $request->input('password_New');
        $UserEmail = $request->input('email');

        // dd($UserEmail);

        $hashNewPassword = Hash::make($newPassword);


        User::where('email', $request->email)->update([
            'password' => $hashNewPassword
        ]);

        return redirect()->route('LoginPage');
    }



    public function Send_Password_to_User(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);


        $password = rand(100000, 999999);

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password
        ]);

        SendPasswordJob::dispatch($user, $password);


        return redirect()->route('ForgotPasswordPage')->with('success', 'Otp Sended Successfully!!')->with('email', $request->email);
    }


    // public function checkwhoAccessCart(int $id)
    // {
    //     if (!Auth::check()) {
    //         return redirect()->route('LoginPage');
    //     }

    //     $user = Auth::user();


    //     if ($user->role == 'admin') {
    //         return redirect()->route('dashboard.page');
    //     }

    //     if ($user->role == 'seller' || $user->role == 'user') {

    //         $user_id =   Auth::user()->id;

    //         $product_id = $id;
    //         $p = Product::all();

    //         $Cart = Cart::where('user_id', $user_id)->where('product_id', $product_id)->first();
    //         $p = Product::find($product_id);

    //         Cart::where('user_id', $user_id)->updateOrCreate([
    //             'user_id' => $user_id,
    //             'product_id' => $product_id,
    //         ], [
    //             'price' => $p->product_price,
    //             'quantity' =>  $Cart ? $Cart->quantity + 1 : 1,
    //         ]);


    //         return redirect()->route('e-commerce-page')->with('success', ' ');
    //     }
    // }



    public function checkwhoAccessCart(int $variant_id)
    {
        if (!Auth::check()) {
            return redirect()->route('LoginPage');
        }

        $user = Auth::user();

        if ($user->role == 'admin') {
            return redirect()->route('dashboard.page');
        }

        if ($user->role == 'seller' || $user->role == 'user') {

            $user_id = $user->id;

            // ✅ Variant find kar
            $variant = ProductVariant::find($variant_id);

            if (!$variant) {
                return back()->with('error', 'Variant not found');
            }

            // ✅ Check cart
            $cart = Cart::where('user_id', $user_id)
                ->where('variant_id', $variant_id)
                ->first();

            // ✅ Update or Create
            Cart::updateOrCreate(
                [
                    'user_id' => $user_id,
                    'variant_id' => $variant_id,
                ],
                [
                    'price' => $variant->price,
                    'quantity' => $cart ? $cart->quantity + 1 : 1,
                ]
            );

            return redirect()->route('e-commerce-page')->with('success', 'Added to cart');
        }
    }
}
