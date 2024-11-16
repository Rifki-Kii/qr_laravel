<?php

namespace Database\Seeders;

use App\Models\qrScan;
use App\Models\Scan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ['id' => 1, 'title' => "simposium"],
            ['id' => 2, 'title' => "workshop 1"],
            ['id' => 3, 'title' => "workshop 2"],
            ['id' => 4, 'title' => "workshop 3"],
            ['id' => 5, 'title' => "workshop 4"],
            ['id' => 8, 'title' => "pameran"],
            ['id' => 9, 'title' => "snack"],

        ];

        foreach ($datas as $key => $data) {
            Scan::create($data);
    }
}
}
