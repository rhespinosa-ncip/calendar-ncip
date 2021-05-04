<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PDSController extends Controller
{

    public function index(Request $request){
        $data = array(
            'user' => User::whereId(Auth::id())->first()
        );

        return view('auth.pds.index', compact('data'));
    }

}
