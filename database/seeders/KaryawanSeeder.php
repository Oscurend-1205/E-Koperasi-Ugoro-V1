<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Pengurus
            ['name' => 'Drs. H. Mulyono', 'position' => 'Ketua Koperasi', 'type' => 'Pengurus', 'nip' => '19780512-001', 'order_num' => 1],
            ['name' => 'Siti Aminah, S.E.', 'position' => 'Sekretaris', 'type' => 'Pengurus', 'nip' => '19820921-002', 'order_num' => 2],
            ['name' => 'Andi Pratama, Ak.', 'position' => 'Bendahara', 'type' => 'Pengurus', 'nip' => '19850110-003', 'order_num' => 3],
            
            // Pengawas
            ['name' => 'Ir. Hendro Saputro', 'position' => 'Ketua Pengawas', 'type' => 'Pengawas', 'nip' => '19650228-001', 'order_num' => 1],
            ['name' => 'Hj. Nurlaila, S.Pd.', 'position' => 'Anggota Pengawas', 'type' => 'Pengawas', 'nip' => '19701115-002', 'order_num' => 2],
            
            // Karyawan
            ['name' => 'Rizky Ramadhan', 'position' => 'Admin Kredit', 'type' => 'Karyawan', 'nip' => 'EMP-004', 'order_num' => 1],
            ['name' => 'Diana Putri', 'position' => 'Customer Service', 'type' => 'Karyawan', 'nip' => 'EMP-005', 'order_num' => 2],
            ['name' => 'Hendra Wijaya', 'position' => 'Field Officer', 'type' => 'Karyawan', 'nip' => 'EMP-006', 'order_num' => 3],
            ['name' => 'Maya Sari', 'position' => 'Teller', 'type' => 'Karyawan', 'nip' => 'EMP-007', 'order_num' => 4],
            ['name' => 'Bambang S.', 'position' => 'Logistik', 'type' => 'Karyawan', 'nip' => 'EMP-008', 'order_num' => 5],
            ['name' => 'Eko Prasetyo', 'position' => 'Security', 'type' => 'Karyawan', 'nip' => 'EMP-009', 'order_num' => 6],
            ['name' => 'Rina Melati', 'position' => 'Admin Tabungan', 'type' => 'Karyawan', 'nip' => 'EMP-010', 'order_num' => 7],
            ['name' => 'Fajar Sidik', 'position' => 'IT Support', 'type' => 'Karyawan', 'nip' => 'EMP-011', 'order_num' => 8],
        ];

        foreach ($data as $item) {
            \App\Models\Karyawan::create($item);
        }
    }
}
