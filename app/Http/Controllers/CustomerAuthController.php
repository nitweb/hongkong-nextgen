<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CustomerAuthController extends Controller
{
    /* ===== Login ===== */
    public function login()
    {
        return view('frontend.customer.auth.login');
    } // End Method

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (
            Auth::guard('user')->attempt([
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'customer',
                'status' => '1',
            ])
        ) {
            return redirect()->route('customer.dashboard')->with('success', 'Welcome back!');
        }

        return back()->with('error', 'Invalid credentials');
    } // End Method

    /* ===== Register ===== */
    public function register()
    {
        return view('frontend.customer.auth.register');
    } // End Method

    public function registerSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => 'avatar.png',
            'role' => 'customer',
            'status' => '1',
        ]);

        return redirect()->route('customer.login')->with('success', 'Account created successfully');
    } // End Method

    /* ===== Dashboard ===== */
    public function dashboard()
    {
        $customer = Auth::guard('user')->user();
        return view('frontend.customer.dashboard', compact('customer'));
    } // End Method

    /* ===== Update Profile ===== */
    public function profileUpdate(Request $request)
    {
        $id = Auth::guard('user')->id();

        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        $old_photo_path = $data->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $manager = new ImageManager(new Driver());
            $file_name = uniqid('customer_', true) . '.' . $file->getClientOriginalExtension();
            $img = $manager->read($file->getRealPath());
            $img->resize(300, 300);
            $img->save(public_path('upload/customer_images/') . $file_name);
            $data->photo = $file_name;

            if ($old_photo_path && $old_photo_path !== $file_name) {
                $this->DeleteOldImage($old_photo_path);
            }
        }

        $data->save();

        $notification = [
            'message' => 'Customer Profile Updated Successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    private function DeleteOldImage(string $old_photo_path): void
    {
        $full_path = public_path('upload/customer_images/' . $old_photo_path);

        if (file_exists($full_path)) {
            unlink($full_path);
        }
    } // End Private Method

    /* ===== Change Password ===== */
    public function changePassword(Request $request)
    {
        $customer = Auth::guard('user')->user();

        if (!$customer) {
            return back()->with([
                'message' => 'Unauthorized access!',
                'alert-type' => 'error',
            ]);
        }

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        if (!Hash::check($request->old_password, $customer->password)) {
            return back()->with([
                'message' => 'Old Password Does Not Match!',
                'alert-type' => 'error',
            ]);
        }

        $customer->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with([
            'message' => 'Password changed successfully!',
            'alert-type' => 'success',
        ]);
    }

    /* ===== Logout ===== */
    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('customer.login')->with('success', 'Logged out successfully');
    }
}
