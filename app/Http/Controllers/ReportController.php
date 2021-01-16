<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function indexAccomplishment(){
        return view('auth.report.accomplishment.index');
    }

    public function indexTiTo(){
        return view('auth.report.tito.index');
    }
}
