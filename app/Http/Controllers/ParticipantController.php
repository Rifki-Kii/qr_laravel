<?php

namespace App\Http\Controllers;

use App\Mail\ParticipanRegistered; // Corrected namespace and class name
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Milon\Barcode\DNS2D;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Facade;
use phpDocumentor\Reflection\PseudoTypes\True_;

class ParticipantController extends Controller
{
    public function register() {
        return view("participant.register-participant");
    }

    public function register_store(Request $request)
    {
        set_time_limit(0); // Increase script execution time

        // Validation of form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email',
            'phone' => 'required|string|max:20|min:8',
        ]);

        // Create a new participant record
        $participant = new Participant();
        $participant->name = $request->name;
        $participant->email = $request->email;
        $participant->phone = $request->phone;

        // Generate unique QR code content
        $qr_content = "meetap- " . time();
        $participant->qr_content = $qr_content;

        // Save the participant to the database
        $result = $participant->save();

        //make pdf
        $background = url("assets/image/background-01.jpg");

        // Generate QR code using DNS2D
        $barcode = new DNS2D();
        $qr_code = $barcode->getBarcodePNG($qr_content, 'QRCODE', 100, 100, [0, 0, 0], true);



        // Create the PDF from the view
        $pdf = Pdf::loadHTML(view("participant.registration-card-pdf", compact("background", "qr_code", "participant")));
        $pdf->setOption("is_remote_enabled", true); // Enable remote assets (like images)
        $pdf->setPaper("a5", "portrait");

        // Create directory if it doesn't exist

        if (!is_dir(public_path("uploads/id_cards"))) {
            mkdir(public_path(("uploads/id_cards")), 0777, true);
        }

        // Save the generated PDF to the file system
    $pdf->save(public_path("uploads/id_cards". $qr_content . ".pdf"));

        // Send the email with the attached PDF
        Mail::to($participant->email)->send(new ParticipanRegistered($participant, null, public_path("uploads/id_cards". $qr_content . ".pdf")));

        // Return a response indicating success
        return redirect("/participant/register")->with('status', 'Data berhasil disimpan, silakan cek email Anda.');
    }
}


