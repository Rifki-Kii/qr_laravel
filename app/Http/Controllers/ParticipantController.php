<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function register()
        {
            return view("participant.register-participant");
        }
}
