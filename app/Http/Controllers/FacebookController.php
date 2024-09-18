<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{
    public function facebookPage(){
        return Socialite::driver('facebook')->redirect('');
    }

    public function facebook_redirect(){

        try{
            $user = Socialite::driver('facebook')->user();
            $find_user = User::where('facebook_id', $user->id)->first();

            if($find_user){
                Auth::login($find_user);
                return redirect()->intended('dashboard');
            }else{
                $newUser = User::updateOrCreate(['email' => $user->email],[
                    'name' => $user->name,
                    'facebook_id' => $user->id,
                    'password' => encrypt('12345dummy'),
                ]);

                Auth::login($newUser);
                return redirect()->intended('dashboard');
            }
        }catch(Exception $e){
            dd($e->getMessage());
        }

    }
}
