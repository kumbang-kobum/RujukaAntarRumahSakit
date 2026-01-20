<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BootstrapSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Rumah Sakit
        $hospitalId = DB::table('hospitals')->insertGetId([
            'name' => 'RS Demo A',
            'address' => 'Alamat RS Demo',
            'phone' => '021000000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Poliklinik
        $departments = [
            'IGD',
            'Poli Umum',
            'Poli Penyakit Dalam',
            'Poli Anak'
        ];

        foreach ($departments as $name) {
            DB::table('departments')->insert([
                'hospital_id' => $hospitalId,
                'name' => $name,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Assign user → hospital_id (DEV ONLY)
        DB::table('users')->update([
            'hospital_id' => $hospitalId
        ]);

        DB::table('catalog_procedures')->insert([
        ['hospital_id'=>$hospitalId,'code'=>'PR001','name'=>'Heating','unit'=>'kali','default_price'=>50000,'is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
        ['hospital_id'=>$hospitalId,'code'=>'PR002','name'=>'Nebulizer','unit'=>'kali','default_price'=>75000,'is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
        ]);

        DB::table('catalog_drugs')->insert([
        ['hospital_id'=>$hospitalId,'code'=>'OB001','name'=>'Paracetamol 500mg','unit'=>'tablet','default_price'=>2000,'is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
        ['hospital_id'=>$hospitalId,'code'=>'OB002','name'=>'Amoxicillin 500mg','unit'=>'kapsul','default_price'=>3500,'is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}