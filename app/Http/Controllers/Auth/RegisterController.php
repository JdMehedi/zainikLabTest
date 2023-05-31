<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'details' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpg, png, jpeg'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => ['recaptcha'],
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Customer
     */
    protected function create(array $data)
    {
        try {
            $img = $data['image'];
            if ($img) {
                $fileName = $img . time();
                $profileName = $fileName . '.' . $img->getClientOriginalExtension();
                $storeData = Storage::putFileAs(
                    'images/profile',
                    $img,
                    $profileName
                );
            }
            return Customer::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'image' => $storeData,
                'details' => $data['details'],
                'status' => true,
                'password' => Hash::make($data['password']),
            ]);
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'User does not Created', $err->getMessage());
        }
    }
}
