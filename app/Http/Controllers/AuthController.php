<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Cashier;
use App\Models\Chef;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function tampilanRegister()
    {
        return view('auth.register');
    }

    public function tampilanLogin()
    {
        return view('auth.login');
    }

    public function tampilanLoginPegawai()
    {
        return view('auth.login-pegawai');
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'username' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'min:3'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'password' => ['required', 'min:8'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'username.required' => 'Username wajib diisi.',
            'username.regex' => 'Username hanya boleh mengandung huruf dan spasi.',
            'username.min' => 'Username minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $data = [
            'id' => $customer->customer_id,
            'username' => $customer->username,
        ];
        session()->put('customer', $data);

        return redirect()->route('menu')->with('success', 'Akun berhasil dibuat!');
    }

    public function login(Request $request)
    {

        $request->validate([
            'username' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'password' => ['required', 'min:8'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.regex' => 'Username hanya boleh mengandung huruf dan spasi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $customer = Customer::where('username', $request->username)->first();

        // LOGIN CUSTOMER
        if ($customer && password_verify($request->password, $customer->password)) {
            $data = [
                'id' => $customer->customer_id,
                'username' => $customer->username,
            ];
            session()->put('customer', $data);
            return redirect()->route('menu')->with('success', 'Anda berhasil login!');
        }

        return redirect()->back()->with('fail', 'Email atau password salah!');
    }

    public function loginPegawai(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $admin = Admin::where('email', $request->email)->first();
        $cashier = Cashier::where('email', $request->email)->first();
        $chef = Chef::where('email', $request->email)->first();

        // LOGIN ADMIN
        if ($admin && password_verify($request->password, $admin->password)) {
            $data = [
                'id' => $admin->admin_id,
                'name' => $admin->name,
            ];
            session()->put('admin', $data);
            return redirect()->route('admin-dashboard')->with('success', 'Anda berhasil login!');
        }

        // LOGIN CASHIER
        if ($cashier && password_verify($request->password, $cashier->password)) {
            $data = [
                'id' => $cashier->cashier_id,
                'name' => $cashier->name,
            ];
            session()->put('cashier', $data);
            return redirect()->route('cashier-dashboard')->with('success', 'Anda berhasil login!');
        }

        // LOGIN CHEF
        if ($chef && password_verify($request->password, $chef->password)) {
            $data = [
                'id' => $chef->chef_id,
                'name' => $chef->name,
            ];
            session()->put('chef', $data);
            return redirect()->route('chef-dashboard')->with('success', 'Anda berhasil login!');
        }

        return redirect()->back()->with('fail', 'Email atau password salah!');
    }

    public function logout()
    {
        session()->forget('customer');

        return redirect()->route('login')->with('success', 'Anda berhasil logout!');
    }

    public function logoutPegawai()
    {
        session()->forget('admin');
        session()->forget('cashier');
        session()->forget('chef');

        return redirect()->route('login-pegawai')->with('success', 'Anda berhasil logout!');
    }
}
