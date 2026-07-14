@extends('layouts.app')

@section('title', 'Tambah KRS')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Tambah KRS</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('transaksi-krs.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('transaksi-krs.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="nim">Mahasiswa</label>
                    <select class="form-select" id="nim" name="nim" required>
                        <option value="">Pilih mahasiswa</option>
                        @foreach($mahasiswa as $item)
                            <option value="{{ $item->nim }}" @selected(old('nim') == $item->nim)>{{ $item->nama }} - {{ $item->nim }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="kode_mk">Mata Kuliah</label>
                    <select class="form-select" id="kode_mk" name="kode_mk" required>
                        <option value="">Pilih mata kuliah</option>
                        @foreach($mataKuliah as $item)
                            <option value="{{ $item->kode_mk }}" @selected(old('kode_mk') == $item->kode_mk)>{{ $item->nama_mk }} - {{ $item->kode_mk }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="semester_tempuh">Semester</label>
                    <input class="form-control" type="number" min="1" id="semester_tempuh" name="semester_tempuh" value="{{ old('semester_tempuh', 1) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="tahun_akademik">Tahun Akademik</label>
                    <input class="form-control" id="tahun_akademik" name="tahun_akademik" value="{{ old('tahun_akademik') }}" placeholder="2025/2026" required>
                </div>


            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div id="fuzzyIndicator" class="alert alert-secondary">
                        Pilih mahasiswa dan mata kuliah untuk melihat rekomendasi fuzzy.
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('transaksi-krs.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const mahasiswaData = @json($mahasiswa->mapWithKeys(function($m) {
    return [$m->nim => ['ipk' => $m->ipk, 'semester' => $m->semester]];
}));
const matkulData = @json($mataKuliah->mapWithKeys(function($mk) {
    return [$mk->kode_mk => ['sks' => $mk->sks]];
}));

function mfRendah(x, a, b, c) { return x <= a ? 1 : (x >= c ? 0 : (c - x) / (c - a)); }
function mfSedang(x, a, b, c) {
    if (x <= a || x >= c) return 0;
    if (x >= b) return (c - x) / (c - b);
    return (x - a) / (b - a);
}
function mfTinggi(x, a, b, c) { return x <= a ? 0 : (x >= c ? 1 : (x - a) / (c - a)); }

function mfSegitiga(x, a, b, c) {
    if (x <= a || x >= c) return 0;
    if (x === b) return 1;
    if (x > a && x < b) return (x - a) / (b - a);
    return (c - x) / (c - b);
}

function hitungKelayakanKRS() {
    const nim = document.getElementById('nim').value;
    const kodeMk = document.getElementById('kode_mk').value;
    const semester = parseInt(document.getElementById('semester_tempuh').value) || 1;

    if (!nim || !kodeMk) {
        document.getElementById('fuzzyIndicator').className = 'alert alert-secondary';
        document.getElementById('fuzzyIndicator').innerHTML = 'Pilih mahasiswa dan mata kuliah untuk melihat rekomendasi fuzzy.';
        return;
    }

    const mhs = mahasiswaData[nim];
    const mk = matkulData[kodeMk];
    if (!mhs || !mk) return;

    const ipk = mhs.ipk || 2.5;
    const bebanSks = mk.sks || 3;

    const ipkR = mfSegitiga(ipk, 0, 0, 2.0);
    const ipkS = mfSegitiga(ipk, 1.5, 2.75, 3.5);
    const ipkT = mfSegitiga(ipk, 2.8, 4.0, 4.0);

    const sksR = mfSegitiga(bebanSks, 0, 0, 2);
    const sksS = mfSegitiga(bebanSks, 1, 3, 4);
    const sksB = mfSegitiga(bebanSks, 3, 6, 6);

    const semA = mfSegitiga(semester, 0, 0, 4);
    const semT = mfSegitiga(semester, 2, 5, 8);
    const semAk = mfSegitiga(semester, 6, 14, 14);

    const rules = [
        { a: ['Rendah', 'Berat', 'Tengah', 'TidakLulus'], o: 'TidakLayak', p: 70 },
        { a: ['Rendah', 'Berat', 'Awal', 'TidakLulus'], o: 'TidakLayak', p: 70 },
        { a: ['Rendah', 'Berat', 'Awal', 'Lulus'], o: 'KurangLayak', p: 70 },
        { a: ['Rendah', 'Berat', 'Tengah', 'Lulus'], o: 'KurangLayak', p: 70 },
        { a: ['Rendah', 'Sedang', 'Awal', 'TidakLulus'], o: 'TidakLayak', p: 70 },
        { a: ['Rendah', 'Sedang', 'Awal', 'Lulus'], o: 'KurangLayak', p: 70 },
        { a: ['Rendah', 'Sedang', 'Tengah', 'Lulus'], o: 'KurangLayak', p: 70 },
        { a: ['Rendah', 'Ringan', 'Awal', 'Lulus'], o: 'Layak', p: 70 },
        { a: ['Rendah', 'Ringan', 'Awal', 'TidakLulus'], o: 'KurangLayak', p: 70 },
        { a: ['Rendah', 'Ringan', 'Tengah', 'Lulus'], o: 'Layak', p: 70 },
        { a: ['Rendah', 'Berat', 'Akhir', 'Lulus'], o: 'KurangLayak', p: 70 },
        { a: ['Rendah', 'Berat', 'Akhir', 'TidakLulus'], o: 'TidakLayak', p: 70 },
        { a: ['Sedang', 'Berat', 'Awal', 'Lulus'], o: 'Layak', p: 70 },
        { a: ['Sedang', 'Berat', 'Awal', 'TidakLulus'], o: 'KurangLayak', p: 70 },
        { a: ['Sedang', 'Berat', 'Tengah', 'Lulus'], o: 'Layak', p: 70 },
        { a: ['Sedang', 'Berat', 'Tengah', 'TidakLulus'], o: 'KurangLayak', p: 70 },
        { a: ['Sedang', 'Sedang', 'Awal', 'Lulus'], o: 'Layak', p: 70 },
        { a: ['Sedang', 'Sedang', 'Awal', 'TidakLulus'], o: 'KurangLayak', p: 70 },
        { a: ['Sedang', 'Sedang', 'Tengah', 'Lulus'], o: 'Layak', p: 70 },
        { a: ['Sedang', 'Sedang', 'Tengah', 'TidakLulus'], o: 'KurangLayak', p: 70 },
        { a: ['Sedang', 'Ringan', 'Awal', 'Lulus'], o: 'SangatLayak', p: 70 },
        { a: ['Sedang', 'Ringan', 'Awal', 'TidakLulus'], o: 'Layak', p: 70 },
        { a: ['Sedang', 'Ringan', 'Tengah', 'Lulus'], o: 'SangatLayak', p: 70 },
        { a: ['Sedang', 'Ringan', 'Tengah', 'TidakLulus'], o: 'Layak', p: 70 },
        { a: ['Sedang', 'Berat', 'Akhir', 'Lulus'], o: 'Layak', p: 70 },
        { a: ['Sedang', 'Berat', 'Akhir', 'TidakLulus'], o: 'KurangLayak', p: 70 },
        { a: ['Tinggi', 'Berat', 'Awal', 'Lulus'], o: 'SangatLayak', p: 70 },
        { a: ['Tinggi', 'Berat', 'Awal', 'TidakLulus'], o: 'Layak', p: 70 },
        { a: ['Tinggi', 'Berat', 'Tengah', 'Lulus'], o: 'SangatLayak', p: 70 },
        { a: ['Tinggi', 'Berat', 'Tengah', 'TidakLulus'], o: 'Layak', p: 70 },
        { a: ['Tinggi', 'Sedang', 'Awal', 'Lulus'], o: 'SangatLayak', p: 70 },
        { a: ['Tinggi', 'Sedang', 'Awal', 'TidakLulus'], o: 'Layak', p: 70 },
        { a: ['Tinggi', 'Sedang', 'Tengah', 'Lulus'], o: 'SangatLayak', p: 70 },
        { a: ['Tinggi', 'Sedang', 'Tengah', 'TidakLulus'], o: 'Layak', p: 70 },
        { a: ['Tinggi', 'Ringan', 'Awal', 'Lulus'], o: 'SangatLayak', p: 70 },
        { a: ['Tinggi', 'Ringan', 'Awal', 'TidakLulus'], o: 'SangatLayak', p: 70 },
        { a: ['Tinggi', 'Ringan', 'Tengah', 'Lulus'], o: 'SangatLayak', p: 70 },
        { a: ['Tinggi', 'Ringan', 'Tengah', 'TidakLulus'], o: 'Layak', p: 70 },
        { a: ['Tinggi', 'Berat', 'Akhir', 'Lulus'], o: 'Layak', p: 70 },
        { a: ['Tinggi', 'Berat', 'Akhir', 'TidakLulus'], o: 'KurangLayak', p: 70 },
        { a: ['Tinggi', 'Sedang', 'Akhir', 'Lulus'], o: 'SangatLayak', p: 70 },
        { a: ['Tinggi', 'Sedang', 'Akhir', 'TidakLulus'], o: 'Layak', p: 70 },
        { a: ['Rendah', 'Sedang', 'Akhir', 'TidakLulus'], o: 'TidakLayak', p: 70 },
        { a: ['Rendah', 'Sedang', 'Akhir', 'Lulus'], o: 'KurangLayak', p: 70 },
        { a: ['Rendah', 'Ringan', 'Akhir', 'Lulus'], o: 'Layak', p: 70 },
        { a: ['Rendah', 'Ringan', 'Akhir', 'TidakLulus'], o: 'KurangLayak', p: 70 },
    ];

    const getMF = (varName, label) => {
        if (varName === 'ipk') {
            return label === 'Rendah' ? ipkR : label === 'Sedang' ? ipkS : ipkT;
        } else if (varName === 'beban_sks') {
            return label === 'Ringan' ? sksR : label === 'Sedang' ? sksS : sksB;
        } else if (varName === 'semester') {
            return label === 'Awal' ? semA : label === 'Tengah' ? semT : semAk;
        } else if (varName === 'nilai_prasyarat') {
            return label === 'TidakLulus' ? mfSegitiga(70, 0, 0, 55) : mfSegitiga(70, 45, 100, 100);
        }
        return 0;
    };

    const outputMF = {
        TidakLayak: { a: 0, b: 0, c: 35 },
        KurangLayak: { a: 20, b: 40, c: 55 },
        Layak: { a: 40, b: 60, c: 75 },
        SangatLayak: { a: 65, b: 100, c: 100 },
    };

    const results = { TidakLayak: 0, KurangLayak: 0, Layak: 0, SangatLayak: 0 };

    for (const rule of rules) {
        const [ipkL, sksL, semL, prasyaratL] = rule.a;
        const s1 = getMF('ipk', ipkL);
        const s2 = getMF('beban_sks', sksL);
        const s3 = getMF('semester', semL);
        const s4 = getMF('nilai_prasyarat', prasyaratL);
        const minS = Math.min(s1, s2, s3, s4);
        results[rule.o] = Math.max(results[rule.o], minS);
    }

    let numerator = 0, denominator = 0;
    for (let x = 0; x <= 100; x += 1) {
        let m = 0;
        for (const [label, mf] of Object.entries(outputMF)) {
            const d = Math.min(results[label], mfSegitiga(x, mf.a, mf.b, mf.c));
            m = Math.max(m, d);
        }
        numerator += x * m;
        denominator += m;
    }
    const skor = denominator > 0 ? Math.round((numerator / denominator) * 100) / 100 : 0;
    let label = '-';
    if (skor >= 65) label = 'Sangat Layak';
    else if (skor >= 45) label = 'Layak';
    else if (skor >= 30) label = 'Kurang Layak';
    else label = 'Tidak Layak';

    const indicator = document.getElementById('fuzzyIndicator');
    const badgeClass = label === 'Sangat Layak' ? 'text-bg-success' : (label === 'Layak' ? 'text-bg-primary' : (label === 'Kurang Layak' ? 'text-bg-warning' : 'text-bg-danger'));
    indicator.className = 'alert';
    indicator.className = 'alert d-flex justify-content-between align-items-center';
    if (label === 'Sangat Layak') indicator.className += ' alert-success';
    else if (label === 'Layak') indicator.className += ' alert-primary';
    else if (label === 'Kurang Layak') indicator.className += ' alert-warning';
    else indicator.className += ' alert-danger';

    indicator.innerHTML = `
        <div>
            <strong>Rekomendasi Fuzzy:</strong><br>
            <small>IPK: ${ipk} | SKS: ${bebanSks} | Semester: ${semester}</small>
        </div>
        <div class="text-end">
            <span class="badge ${badgeClass} fs-6 px-3 py-2">${label}</span><br>
            <small>Skor: ${skor}</small>
        </div>
    `;
}

document.addEventListener('DOMContentLoaded', function () {
    ['nim', 'kode_mk', 'semester_tempuh'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('change', hitungKelayakanKRS);
    });
    document.getElementById('semester_tempuh')?.addEventListener('input', hitungKelayakanKRS);
});
</script>
@endpush

