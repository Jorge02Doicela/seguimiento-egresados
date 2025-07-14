<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Graduate;
use App\Models\Employer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'role' => ['required', 'in:graduate,employer'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'sector' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
        ];

        if ($request->role === 'employer') {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['phone'] = ['required', 'string', 'max:50'];
            $rules['address'] = ['required', 'string', 'max:255'];
            $rules['sector'] = ['required', 'string', 'max:255'];
            $rules['city'] = ['required', 'string', 'max:100'];
        } else {
            $rules['company_name'] = ['nullable'];
        }

        $request->validate($rules);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        if ($request->role === 'graduate') {
            Graduate::create([
                'user_id' => $user->id,
                'cohort_year' => now()->year,
                'gender' => 'Otro',
                'company' => null,
                'position' => null,
                'salary' => null,
                'sector' => null,
                'portfolio_url' => null,
                'cv_path' => null,
                'country' => null,
                'city' => $request->city,
            ]);
        } elseif ($request->role === 'employer') {
            Employer::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'website' => $request->website,
                'sector' => $request->sector,
                'city' => $request->city,
                'is_verified' => false,
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
