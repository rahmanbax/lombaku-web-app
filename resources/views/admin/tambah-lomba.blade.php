@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Jubil Combo</h1>

    <div class="card">
        <div class="card-body">
            <h2>Agriculture Competition</h2>
            <h3>Desir/ipai</h3>
            
            <div class="mb-4">
                <h4>AGRICULTURE COMPETITION 2025</h4>
                <p>Assentomusbakum var vkb.</p>
                <p>Seiten muntasivet</p>
                <p>Kornu puryro baktat terpendom di böceng senk esport, otou koryo tullis?</p>
                <p>Sostinyo untuk gigi den jbatikan potentiimu prestasi nyutsu</p>
            </div>

            <form>
                <div class="form-group mb-3">
                    <label>Kotagari Lomba</label>
                    <select class="form-control">
                        <option>Infografis, Musik, Seminar</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Tingleton</label>
                    <select class="form-control">
                        <option>Netsorati</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Lokesi</label>
                    <select class="form-control">
                        <option>Online</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Tonggal dahir perioditoron</label>
                    <input type="text" class="form-control" value="15/05/2025">
                </div>

                <div class="form-group mb-3">
                    <label>Tonggal mulal sekelai</label>
                    <input type="text" class="form-control" value="16/05/2025">
                </div>

                <div class="form-group mb-3">
                    <label>Tonggal dahir sekelai</label>
                    <input type="text" class="form-control" value="26/05/2025">
                </div>

                <div class="form-group mb-3">
                    <label>Tonggal pengamurmon</label>
                    <input type="text" class="form-control" value="27/05/2025">
                </div>

                <div class="form-group mb-3">
                    <label>Link info Tombahan</label>
                    <input type="text" class="form-control" value="www.lombebu.com">
                </div>

                <div class="form-group mb-3">
                    <label>Upload Poster Lomba</label>
                    <input type="file" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection