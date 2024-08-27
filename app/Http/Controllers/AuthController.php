<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserManagement\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            $username_check = User::whereNull('deleted_at')
                ->where('username', $request->username)
                ->first();

            if (!is_null($username_check)) {
                if (Auth::attempt(['username' => $request->username, 'password' => $request->password], isset($request->remember))) {
                    $request->session()->regenerate();
                    // For Request Url
                    $intended_url = session()->pull('url.intended', route('home'));
                    return redirect()->to($intended_url);
                } else {
                    return redirect()
                        ->back()
                        ->withErrors(['username' => 'These credentials do not match our records.'])
                        ->withInput();
                }
            } else {
                return redirect()
                    ->back()
                    ->withErrors(['username' => 'These credentials do not match our records.'])
                    ->withInput();
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['username' => $e->getMessage()])
                ->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function create()
    {
        return view('auth.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'phone' => $request->phone,
                'address' => $request->address,
                'password' => Hash::make($request->password),
            ]);


            $model_has_role = $user->assignRole('customer');
            DB::commit();
            return redirect()->route('login')->with('success', 'User created successfully.');
        } catch (Exception $e) {
            dd($e);
        }
    }

}
