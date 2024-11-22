<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator as IlluminateValidationValidator;
use Illuminate\Support\Facades\Validator;


class ScanController extends Controller
{
    /**
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
}
