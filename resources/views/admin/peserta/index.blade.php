@extends('layouts.admin')

@section('content')
<h2>Data Peserta Lomba</h2>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>NIM</th>
            <th>Lomba</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($peserta as $p)
        <tr>
            <td>{{ $p->nama }}</td>
            <td>{{ $p->nim }}</td>
            <td>{{ $p->lomba->nama ?? '-' }}</td>
            <td>{{ $p->status }}</td>
            <td><a href="{{ route('admin.peserta.verifikasi', $p->id) }}">Verifikasi</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
