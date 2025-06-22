<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminPanelController extends Controller
{
    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        // Redirect to admin dashboard if already logged in
        if (Auth::guard('admin')->check()) {
            return redirect('/admin');
        }

        return view('admin.login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            // For regular form submissions, redirect back with errors
            if (!$request->expectsJson() && !$request->ajax()) {
                return back()->withErrors($validator)->withInput();
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Please provide valid username and password.',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('username', 'password');

        // Use the 'admin' guard instead of the default 'web' guard
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            // Check if it's an AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful',
                    'redirect' => url('/admin')
                ]);
            }

            // For regular form submissions, redirect directly
            return redirect()->intended('/admin')->with('success', 'Welcome back, you have logged in successfully!');
        }

        // Handle failed login for both AJAX and regular requests
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid username or password.'
            ], 401);
        }

        return back()->withErrors([
            'username' => 'Invalid username or password.'
        ])->withInput();
    }

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        // Check if admin is authenticated using the admin guard
        if (!Auth::guard('admin')->check()) {
            return redirect('/admin/login')->with('error', 'Please login to access admin panel.');
        }

        // Debug: Log that we're accessing the admin dashboard
        \Log::info('Admin dashboard accessed by: ' . Auth::guard('admin')->user()->username);

        return view('admin_dost')->with('success', 'Welcome back, you have logged in successfully!');

    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        // Logout from the admin guard
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}