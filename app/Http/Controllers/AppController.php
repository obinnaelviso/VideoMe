<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use OpenTok\OpenTok;
use Auth;

class AppController extends Controller
{
    public function index() {
        return view('index');
    }

    public function login(Request $request) {
        $user = User::whereUsername($request->username)->first();
        if($user) {
            Auth::login($user);
            return redirect()->route('chatroom');
        }

        return redirect()->route('index')->with('failed', 'Invalid Username! Please check the manual for correct login details!');
    }
    
    public function chatroom() {
        $user = $this->user();
        $session_id = $user->session_id;
        $o_users = User::all()->except($user->id);
        $api_key = env('OPENTOK_API_KEY');
        // Generate User Token
        $this->generateUserToken($user);
        return view('chatroom',compact(['session_id', 'user', 'o_users', 'api_key']));
    }

    public function user() {
        return Auth::user();
    }

    public function generateToken($session_id) {
        $otApi = new OpenTok(env('OPENTOK_API_KEY'), env('OPENTOK_API_SECRET'));

        return $otApi->generateToken($session_id);
    }

    public function generateUserToken($user) {
        $user->session_token = $this->generateToken($user->session_id);
        $user->save();
    }
}
