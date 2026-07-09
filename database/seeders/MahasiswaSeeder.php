<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nim' => '2155201110011', 'nama' => 'DICKI PRASTIA PAUZI'],
            ['nim' => '2455201110002', 'nama' => 'AKMAL MAULANA YUSUF'],
            ['nim' => '2455201110003', 'nama' => 'HALIS ANNISA'],
            ['nim' => '2455201110004', 'nama' => 'HARY NUR AFANDI'],
            ['nim' => '2455201110005', 'nama' => 'I DEWA GEDE ARYA PRAMEISA'],
            ['nim' => '2455201110006', 'nama' => 'LUTHFI AHMAD FAHREZI'],
            ['nim' => '2455201110007', 'nama' => 'LUTHFIANA SAFITRI'],
            ['nim' => '2455201110009', 'nama' => 'MOCHAMMAD SYAHID FARIZ ABQARI'],
            ['nim' => '2455201110010', 'nama' => 'MUHAMMAD FAJAR AULIA'],
            ['nim' => '2455201110012', 'nama' => 'MUHAMMAD RYAN HIDAYAT'],
            ['nim' => '2455201110013', 'nama' => 'MUHAMMAD SYAFIQ HUSIN'],
            ['nim' => '2455201110014', 'nama' => 'MUHAMMAD SYAHID FADHILAH'],
            ['nim' => '2455201110015', 'nama' => 'MUHAMMAD SYARIF'],
            ['nim' => '2455201110016', 'nama' => 'NANDA SYALWA NAZELLA'],
            ['nim' => '2455201110017', 'nama' => 'NAZWA AULIA PUTRI'],
            ['nim' => '2455201110018', 'nama' => 'NOR MAYANTI'],
            ['nim' => '2455201110019', 'nama' => 'NUR AISYAH'],
            ['nim' => '2455201110020', 'nama' => 'PENDRI MIKOLA'],
            ['nim' => '2455201110021', 'nama' => 'RAIHAN'],
            ['nim' => '2455201110022', 'nama' => 'RIANTI'],
            ['nim' => '2455201110023', 'nama' => 'RUDI GUNAWAN'],
            ['nim' => '2455201110024', 'nama' => 'SITI HIDAYATUZ ZUHRO'],
            ['nim' => '2455201110025', 'nama' => 'VIONA WINOLA SUPRAPTO'],
            ['nim' => '2455201110026', 'nama' => 'YUDHA MAULANA DARHAM'],
            ['nim' => '2455201110027', 'nama' => 'ZAINABUL ASKYAH'],
            ['nim' => '2455201110028', 'nama' => 'MUHAMMAD AGUS YULIANSYAH'],
            ['nim' => '2455201110030', 'nama' => 'GILANG HERNAWAN SALEM'],
            ['nim' => '2455201110031', 'nama' => 'SAHIDATUL ASIAH'],
        ];

        foreach ($data as $mhs) {
            DB::table('mahasiswa')->insert([
                'nim'           => $mhs['nim'],
                'nama'          => $mhs['nama'],
                'alamat'        => '-',
                'tempat_lahir'  => '-',
                'tanggal_lahir' => '2000-01-01',
                'jenis_kelamin' => 'L',
                'fakultas'      => 'Teknik',
                'prodi'         => 'Informatika',
                'angkatan'      => 2024,
                'semester'      => 4,
                'email'         => strtolower(str_replace(' ', '', $mhs['nama'])) . rand(100, 999) . '@example.com',
                'no_hp'         => '080000000000',
                'status'        => 'Aktif',
                'agama'         => 'Islam',
                'nik'           => rand(1000000000000000, 9999999999999999),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}