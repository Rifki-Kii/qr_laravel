<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Query attendance dengan eager loading relasi scan dan participant
        $attendance = Attendance::with(["scan:id,title", "participant:id,name,email,phone"]) // Relasi "participant", bukan "participants"
            ->orderBy("created_at", "desc")
            ->get();

        // Mengirim data ke view
        return view("report", compact("attendance"));
    }
}
