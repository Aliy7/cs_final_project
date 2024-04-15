<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Mail\UserRegEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

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
            'username' => ['required', 'string', 'max:50', 'unique:' .User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['required', 'string', 'max:30'],
            'phone_number' => ['required', 'string', 'max:15'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()->min(12)
                                                                                ->mixedCase()
                                                                                ->symbols(2),]
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request -> phone_number,
            'password' => Hash::make($request->password),
            
        ]);

        event(new Registered($user));
        Mail::to($user->email)->send(new UserRegEmail($user));

        Auth::login($user);

        // // return redirect(RouteServiceProvider::HOME);
        // return redirect()->route('verification.notice');
        return redirect()->route('verification.notice')
                 ->with('status', 'verification-link-sent');


    }

    public function uniqueUserName(Request $request){
     
        $request->validate([
            'username' => 'required|string|max:50',
        ]);

        $isUnique = !User::where('username', $request->input('username'))->exists();

        return response()->json(['isUnique' => $isUnique]);
        
    }
}
