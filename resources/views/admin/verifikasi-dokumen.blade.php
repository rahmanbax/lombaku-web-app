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
                        <li class="list-group-item">DARTARI OMILIA</li>
                        <li class="list-group-item">VEHİTİKASI DOKUMINI</li>
                        <li class="list-group-item">RIMAYAT PERDARTARAN</li>
                        <li class="list-group-item">AKSHI OMILIA</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h2>Admin Prodi</h2>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Filter</label>
                                <select class="form-control">
                                    <option>Nama Mahasiswa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Mahasiswa</label>
                                <select class="form-control">
                                    <option>Rolf</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Mahasiswa</th>
                                <th>Nama Lamba</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 0; $i < 3; $i++)
                            <tr>
                                <td>Rolf</td>
                                <td>Poster Kesehatan</td>
                                <td>{{ ['Terverifikasi', 'Tidak Lolos', 'Mengundurkan diri'][$i] }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning">Verifikasi</button>
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