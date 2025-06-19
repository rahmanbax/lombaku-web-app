@extends('layouts.admin')

@section('content')
<h2>Verifikasi Peserta</h2>

<form action="{{ route('admin.peserta.verifikasi.store', $peserta->id) }}" method="POST">
    @csrf
    <p><strong>Nama:</strong> {{ $peserta->nama }}</p>
    <p><strong>NIM:</strong> {{ $peserta->nim }}</p>
    <p><strong>Lomba:</strong> {{ $peserta->lomba->nama ?? '-' }}</p>

    <label>Status:</label>
    <select name="status" required>
        <option value="Terdaftar" {{ $peserta->status == 'Terdaftar' ? 'selected' : '' }}>Terdaftar</option>
        <option value="Lolos" {{ $peserta->status == 'Lolos' ? 'selected' : '' }}>Lolos</option>
        <option value="Tidak Lolos" {{ $peserta->status == 'Tidak Lolos' ? 'selected' : '' }}>Tidak Lolos</option>
    </select>

    <button type="submit">Simpan</button>
</form>
@endsection
