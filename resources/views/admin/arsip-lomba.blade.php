@extends('layouts.admin')
@section('content')
<div class="container">
    <h2>Arsip Lomba</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lomba as $item)
            <tr>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ \Carbon\Carbon::parse($item->deadline)->translatedFormat('d F Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
