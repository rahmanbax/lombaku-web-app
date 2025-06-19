@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>LOMBAKU</h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">DASHBOARD</h5>
                    <ul class="list-group">
                        <li class="list-group-item">DATTAR LOMBA</li>
                        <li class="list-group-item">VERIFIKASI DOKUMEN</li>
                        <li class="list-group-item">RIWAYAT PENDATTAFAN</li>
                        <li class="list-group-item">ARSH LOMBA</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h2>Admin Prodi</h2>
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name Lomba</th>
                                <th>Tanggal Deadline</th>
                                <th>Status</th>
                                <th>Jumlah Pendaftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 0; $i < 5; $i++)
                            <tr>
                                <td>Menyanyi</td>
                                <td>10 Agustus 2025</td>
                                <td>Aktif</td>
                                <td>10</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">Lihat</a>
                                    <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <h3>Daftar Lomba</h3>
                        <a href="{{ route('admin.tambah-lomba') }}" class="btn btn-primary">Tambah Lomba +</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection