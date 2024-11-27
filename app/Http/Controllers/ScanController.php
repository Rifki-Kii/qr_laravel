<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\participant;
use App\Models\Scan;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Validation\Validator as IlluminateValidationValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



class ScanController extends Controller
{

    /**
     *
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Scan::get();

        return response ()->json([
            "status" => "success",
            "massage" => "oke",
            "data"=> $data
        ], 200);
    }

    public function show ($id)
    {
        $data = Scan::find($id);

        return response ()->json([
            "status"=> "success",
            "massage" => "oke",
            "data" => $data
        ]
    , 200);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi
    $validator = Validator::make(
        $request->all(),
        [
            "title" => 'required'
        ]
    );

    if ($validator->fails()) {
        return response()->json([
            "status" => "error",
            "message" => "validation errors",
            "errors" => $validator->errors(),
            "data" => []
        ]);
    }

    $scan = new Scan();
    $scan->title = $request->title;

    $result = $scan->save();
    if ($result) {
        return response()->json([
            "status" => "success",
            "message" => "Save data success",
            "data" => []
        ], 200);
    } else {
        return response()->json([
            "status" => "error",
            "message" => "Save data failed"
        ], 200);
    }
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $scan = Scan::find($id);

        if ($scan == null) {
            return response()->json([
                "status"=> "error",
                "message"=> "scan not found",
                "data"=> []
            ], 200);
        }

        $scan->title = $request->title;

        $result = $scan->save();

        if ($result){
            return response()->json([
            "status" =>"success",
            "message" => "update data succes",
            "data"=> []
            ], 200);


        } else {
            return response()->json([
                "status"=> "error",
                "message"=> "Update data failed"
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $scan = Scan::find($id);

        if( $scan == null ) {
            return response()->json([
                "status"=> "error",
                "massage"=> "scan not found",
                "data"=> []
            ], 200  );
    }

    $result = $scan->delete();
    if( $result){
        return response()->json([
            "status"=> "success",
            "message"=> "Delete data succes",
            "data"=> []
        ], 200);
    } else {
        return response()->json([
            "status"=> "error",
            "message"=> "Delete data Failed"
        ], 200);
    }
}
public function scan_qr(Request $request)
{
    // Validasi input
    $request->validate([
        'id_scan' => 'required',
        'qr_content' => 'required',
    ]);

    // Periksa autentikasi pengguna
    $user = Auth::user();

    // Periksa apakah ID Scan valid
    $is_id_scan = Scan::find($request->id_scan);

    if (!$is_id_scan) {
        return response()->json([
            'status' => 'fail',
            'message' => 'Id Scan not found',
            'error' => ['id_scan' => 'Not found']
        ], 404);
    }

    // Periksa apakah QR Content valid
    $is_participant = Participant::where("qr_content", $request->qr_content)->first();

    if (!$is_participant) {
        return response()->json([
            'status' => 'fail',
            'message' => 'Participant not found',
            'error' => ['qr_content' => 'Not found']
        ], 404);
    }

    // Periksa apakah sudah melakukan scan hari ini
    $today = now()->startOfDay();
    $alreadyScan = Attendance::where("participant_id", $is_participant->id)
        ->where("id_scan", $is_id_scan->id)
        ->whereDate("scan_at", $today)
        ->first();

    if ($alreadyScan) {
        return response()->json([
            'status' => 'fail',
            'message' => 'Anda sudah scan hari ini'
        ], 200);
    }

    // Simpan data scan baru
    $attendance = new Attendance();
    $attendance->participant_id = $is_participant->id;
    $attendance->id_scan = $is_id_scan->id;
    $attendance->scan_at = now();
    $attendance->scan_by = $user->id;

    $attendance->save();

    if ($attendance) {
        return response()->json([
            'status' => 'success',
            'message' => $is_id_scan->title . " - " . $request->qr_content . " success",
        ], 200);
    } else {
        return response()->json([
            'status' => 'fail',
            'message' => 'Error when saving data',
        ], 422);
    }
}
}
