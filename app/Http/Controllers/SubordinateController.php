<?php

namespace App\Http\Controllers;

use App\GlobalClass\Datatables;
use App\Models\ActionableItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubordinateController extends Controller
{
    public function index(){
        $actionableItems = ActionableItem::where('personnel', 'individual')->get();

        return view('auth.subordinate.index', compact('actionableItems'));
    }
}
