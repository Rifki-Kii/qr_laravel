<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // Tabel yang digunakan oleh model ini
    protected $table = "attendances";

    // Kolom-kolom yang dapat diisi secara mass-assignment
    protected $fillable = [
        "participant_id",
        "id_scan",
        "scan_at",
        "scan_by",
    ];

    // Relasi ke tabel participants
    public function participant()
    {
        return $this->belongsTo(Participant::class, "participant_id", "id");
    }

    // Relasi ke tabel scans
    public function scan()
    {
        return $this->belongsTo(Scan::class, "id_scan", "id");
    }


}
