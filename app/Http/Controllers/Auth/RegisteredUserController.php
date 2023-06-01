<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . Customer::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'g-recaptcha-response' => ['recaptcha'],
            'details' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpg, png, jpeg'],
        ]);

        $img = $request['image'];
        if ($img) {
            $fileName = $img . time();
            $profileName = $fileName . '.' . $img->getClientOriginalExtension();
            $storeData = Storage::putFileAs(
                'images/profile',
                $img,
                $profileName
            );
        }
        $username = Str::snake($request->name) . rand(5, 10);
        $res =  Customer::where('username', $username)->first();
        if ($res) {
            $username = str::snake($request->name) . rand(5, 10);
        }
        $user = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'details' => $request->details,
            'image' => $storeData,
            'username' => $username,
            'status' => true,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
