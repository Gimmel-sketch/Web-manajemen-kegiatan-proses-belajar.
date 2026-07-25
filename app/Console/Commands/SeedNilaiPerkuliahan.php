<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TransaksiKrs;
use App\Models\TransaksiNilaiPerkuliahan;
use App\Services\FuzzyNilaiService;
use Illuminate\Console\Command;

class SeedNilaiPerkuliahan extends Command
{
    protected $signature = 'nilai:seed';
    protected $description = 'Membuat KRS dan nilai untuk setiap mahasiswa di semua mata kuliah';

    public function handle(): void
    {
        $fuzzyNilai = new FuzzyNilaiService();

        $mahasiswaList = Mahasiswa::all();
        $mataKuliahList = MataKuliah::all();
        $tahunAkademik = '2026/2027';

        $totalKrs = 0;
        $totalNilai = 0;
        $bar = $this->output->createProgressBar($mahasiswaList->count() * $mataKuliahList->count());
        $bar->start();

        foreach ($mahasiswaList as $mahasiswa) {
            foreach ($mataKuliahList as $mk) {
                $krs = TransaksiKrs::firstOrCreate(
                    ['nim' => $mahasiswa->nim, 'kode_mk' => $mk->kode_mk],
                    [
                        'semester_tempuh' => $mahasiswa->semester,
                        'tahun_akademik' => $tahunAkademik,
                        'status_verifikasi' => 'terverifikasi',
                        'verified_at' => now(),
                        'verified_by' => 1,
                    ]
                );

                if ($krs->wasRecentlyCreated) {
                    $totalKrs++;
                }

                $nilaiExists = TransaksiNilaiPerkuliahan::where('transaksi_krs_id', $krs->id)->exists();

                if (!$nilaiExists) {
                    $tugas = rand(60, 100);
                    $uts = rand(60, 100);
                    $uas = rand(60, 100);

                    $result = $fuzzyNilai->hitung($tugas, $uts, $uas);

                    TransaksiNilaiPerkuliahan::create([
                        'transaksi_krs_id' => $krs->id,
                        'nilai_tugas' => $tugas,
                        'nilai_uts' => $uts,
                        'nilai_uas' => $uas,
                        'nilai_akhir' => $result['nilai_akhir'],
                        'nilai_huruf' => $result['nilai_huruf'],
                        'keterangan' => 'Lulus',
                    ]);

                    $totalNilai++;
                }

                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info("Selesai! KRS baru: {$totalKrs}, Nilai baru: {$totalNilai}");
    }
}
