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
                        <li class="list-group-item">DATTARLOMBA</li>
                        <li class="list-group-item">VERIFIKASI DOKUMEN</li>
                        <li class="list-group-item">BIHZAYAT PSDDATABAN</li>
                        <li class="list-group-item">ARSH'LOMBA</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Admin Prodi</h2>
                        <a href="#" class="btn btn-danger">Logout</a>
                    </div>
                    
                    <h3 class="mb-4">Daftar Peserta</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nama Lomba</th>
                                <th>Link Dokumen</th>
                                <th>Status Dokumen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 0; $i < 3; $i++)
                            <tr>
                                <td>Rolf</td>
                                <td>Poster Kesehatan</td>
                                <td>www.com</td>
                                <td>Diterima</td>
                                <td>
                                    <button class="btn btn-sm btn-success">Verifikasi</button>
                                    <button class="btn btn-sm btn-danger">Tolak</button>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection