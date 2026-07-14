@extends('layouts.app')

@section('title', 'Tambah Nilai Perkuliahan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">Tambah Nilai Perkuliahan</h1>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('nilai-perkuliahan.index') }}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('nilai-perkuliahan.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="transaksi_krs_id">KRS</label>
                    <select class="form-select" id="transaksi_krs_id" name="transaksi_krs_id" required>
                        <option value="">Pilih KRS</option>
                        @foreach($transaksiKrs as $item)
                            <option value="{{ $item->id }}" @selected(old('transaksi_krs_id') == $item->id)>{{ $item->mahasiswa?->nama }} - {{ $item->mataKuliah?->nama_mk }} - {{ $item->tahun_akademik }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="nilai_tugas">Tugas</label>
                    <input class="form-control" type="number" min="0" max="100" step="0.01" id="nilai_tugas" name="nilai_tugas" value="{{ old('nilai_tugas') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="nilai_uts">UTS</label>
                    <input class="form-control" type="number" min="0" max="100" step="0.01" id="nilai_uts" name="nilai_uts" value="{{ old('nilai_uts') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="nilai_uas">UAS</label>
                    <input class="form-control" type="number" min="0" max="100" step="0.01" id="nilai_uas" name="nilai_uas" value="{{ old('nilai_uas') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="nilai_akhir">Akhir <small class="text-info">(Fuzzy)</small></label>
                    <input class="form-control" type="number" step="0.01" id="nilai_akhir_preview" value="-" readonly disabled>
                    <input type="hidden" id="nilai_akhir" name="nilai_akhir" value="{{ old('nilai_akhir') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="nilai_huruf">Huruf <small class="text-info">(Fuzzy)</small></label>
                    <input class="form-control" id="nilai_huruf_preview" value="-" readonly disabled>
                    <input type="hidden" id="nilai_huruf" name="nilai_huruf" value="{{ old('nilai_huruf') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label" for="keterangan">Keterangan</label>
                    <input class="form-control" id="keterangan" name="keterangan" value="{{ old('keterangan') }}">
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="{{ route('nilai-perkuliahan.index') }}">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function hitungFuzzyNilai() {
    const tugas = parseFloat(document.getElementById('nilai_tugas')?.value) || 0;
    const uts = parseFloat(document.getElementById('nilai_uts')?.value) || 0;
    const uas = parseFloat(document.getElementById('nilai_uas')?.value) || 0;

    const mfRendah = (x) => x <= 0 ? 1 : (x >= 40 ? 0 : (40 - x) / 40);
    const mfSedang = (x) => {
        if (x <= 30 || x >= 70) return 0;
        if (x >= 50) return (70 - x) / 20;
        return (x - 30) / 20;
    };
    const mfTinggi = (x) => x <= 60 ? 0 : (x >= 100 ? 1 : (x - 60) / 40);

    const outputMf = {
        Rendah: { a: 0, b: 0, c: 45 },
        Sedang: { a: 30, b: 55, c: 80 },
        Tinggi: { a: 60, b: 100, c: 100 },
    };

    const mfOutput = (x, m) => {
        if (x <= m.a || x >= m.c) return 0;
        if (x === m.b) return 1;
        if (x > m.a && x < m.b) return (x - m.a) / (m.b - m.a);
        return (m.c - x) / (m.c - m.b);
    };

    const tR = mfRendah(tugas), tS = mfSedang(tugas), tT = mfTinggi(tugas);
    const uR = mfRendah(uts), uS = mfSedang(uts), uT = mfTinggi(uts);
    const uaR = mfRendah(uas), uaS = mfSedang(uas), uaT = mfTinggi(uas);

    const labelMap = { Rendah: 0, Sedang: 1, Tinggi: 2 };
    const labels = ['Rendah', 'Sedang', 'Tinggi'];
    const results = { Rendah: 0, Sedang: 0, Tinggi: 0 };

    for (const tL of labels) {
        for (const uL of labels) {
            for (const uaL of labels) {
                const tV = tL === 'Rendah' ? tR : tL === 'Sedang' ? tS : tT;
                const uV = uL === 'Rendah' ? uR : uL === 'Sedang' ? uS : uT;
                const uaV = uaL === 'Rendah' ? uaR : uaL === 'Sedang' ? uaS : uaT;
                const strength = Math.min(tV, uV, uaV);

                let outLabel;
                if ((tL === 'Tinggi' || uL === 'Tinggi' || uaL === 'Tinggi') && !(tL === 'Rendah' && uL === 'Rendah' && uaL === 'Rendah')) {
                    outLabel = 'Tinggi';
                } else if (tL === 'Tinggi' || uL === 'Tinggi' || uaL === 'Tinggi') {
                    outLabel = 'Tinggi';
                } else if (tL === 'Rendah' || uL === 'Rendah' || uaL === 'Rendah') {
                    outLabel = 'Rendah';
                } else {
                    outLabel = 'Sedang';
                }
                results[outLabel] = Math.max(results[outLabel], strength);
            }
        }
    }

    let numerator = 0, denominator = 0;
    for (let x = 0; x <= 100; x += 1) {
        let m = 0;
        for (const [label, mf] of Object.entries(outputMf)) {
            const d = Math.min(results[label], mfOutput(x, mf));
            m = Math.max(m, d);
        }
        numerator += x * m;
        denominator += m;
    }
    const nilaiAkhir = denominator > 0 ? Math.round((numerator / denominator) * 100) / 100 : 0;
    let nilaiHuruf = '-';
    if (nilaiAkhir >= 80) nilaiHuruf = 'A';
    else if (nilaiAkhir >= 65) nilaiHuruf = 'B';
    else if (nilaiAkhir >= 50) nilaiHuruf = 'C';
    else if (nilaiAkhir >= 35) nilaiHuruf = 'D';
    else if (nilaiAkhir > 0) nilaiHuruf = 'E';

    document.getElementById('nilai_akhir_preview').value = nilaiAkhir;
    document.getElementById('nilai_huruf_preview').value = nilaiHuruf;
    document.getElementById('nilai_akhir').value = nilaiAkhir;
    document.getElementById('nilai_huruf').value = nilaiHuruf;
}

document.addEventListener('DOMContentLoaded', function () {
    ['nilai_tugas', 'nilai_uts', 'nilai_uas'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', hitungFuzzyNilai);
    });
});
</script>
@endpush
