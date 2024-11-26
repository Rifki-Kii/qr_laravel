<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = "participants";
    protected $fillable = [
        "participant_id",
        "id_scan",
        "scan_at",
        "scan_by.",
    ];

    public function participant(){
        return $this->belongsTo(Participant::class, "participant_id", "id");
    }

    public function scan(){
    return $this->belongTo(Scan::class, foreign: "id_can", ownerkey:"id");
    }
}


