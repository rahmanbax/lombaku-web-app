@extends('layouts.admin')
@section('content')
<h2>Integrasi Rekognisi Prestasi</h2>
<form action="{{ route('admin.rekognisi.simpan') }}" method="POST">
    @csrf
    <label>Nama Mahasiswa:</label>
    <input type="text" name="nama_mahasiswa" required>
    <label>Nama Lomba:</label>
    <input type="text" name="lomba" required>
    <label>Jenis Rekognisi:</label>
    <select name="jenis_rekognisi" required>
        <option value="SKS">Konversi SKS</option>
        <option value="Nilai">Penambahan Nilai</option>
        <option value="Sertifikat">Sertifikat</option>
    </select>
    <label>Keterangan:</label>
    <input type="text" name="keterangan">
    <button type="submit">Simpan</button>
</form>

<h3>Filter Statistik</h3>
<form method="GET" action="{{ route('admin.rekognisi') }}">
    <label>Tahun:</label>
    <input type="number" name="tahun" value="{{ request('tahun') }}">
    <label>Jenis Rekognisi:</label>
    <select name="jenis_rekognisi">
        <option value="">Semua</option>
        <option value="SKS" {{ request('jenis_rekognisi') == 'SKS' ? 'selected' : '' }}>SKS</option>
        <option value="Nilai" {{ request('jenis_rekognisi') == 'Nilai' ? 'selected' : '' }}>Nilai</option>
        <option value="Sertifikat" {{ request('jenis_rekognisi') == 'Sertifikat' ? 'selected' : '' }}>Sertifikat</option>
    </select>
    <button type="submit">Filter</button>
</form>

<h3>Statistik Rekognisi</h3>
<div id="chart-container">
    <!-- Placeholder for chart.js or similar lib -->
</div>
@endsection