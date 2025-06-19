@extends('admin.layouts.app')

@section('title', 'Tambah Lomba Baru')

@section('content')
<div class="ml-64 p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Tambah Lomba Baru</h1>
        <a href="{{ route('admin.lomba.index') }}" class="btn-secondary">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.lomba.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div>
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Lomba</label>
                        <input type="text" name="title" id="title" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description" rows="4" required
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category" id="category" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Kategori</option>
                            <option value="Seni">Seni</option>
                            <option value="Olahraga">Olahraga</option>
                            <option value="Sains">Sains</option>
                            <option value="Teknologi">Teknologi</option>
                        </select>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div>
                    <div class="mb-4">
                        <label for="level" class="block text-sm font-medium text-gray-700">Tingkatan</label>
                        <select name="level" id="level" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Tingkatan</option>
                            <option value="Sekolah">Sekolah</option>
                            <option value="Regional">Regional</option>
                            <option value="Nasional">Nasional</option>
                            <option value="Internasional">Internasional</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="location" class="block text-sm font-medium text-gray-700">Lokasi</label>
                        <select name="location" id="location" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Lokasi</option>
                            <option value="Online">Online</option>
                            <option value="Jakarta">Jakarta</option>
                            <option value="Bandung">Bandung</option>
                            <option value="Surabaya">Surabaya</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="registration_start" class="block text-sm font-medium text-gray-700">Tanggal Mulai Pendaftaran</label>
                        <input type="date" name="registration_start" id="registration_start" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="registration_end" class="block text-sm font-medium text-gray-700">Tanggal Akhir Pendaftaran</label>
                        <input type="date" name="registration_end" id="registration_end" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="info_link" class="block text-sm font-medium text-gray-700">Link Info Lomba</label>
                        <input type="url" name="info_link" id="info_link" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="poster" class="block text-sm font-medium text-gray-700">Poster Lomba</label>
                        <input type="file" name="poster" id="poster" required accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="btn-primary">
                    Simpan Lomba
                </button>
            </div>
        </form>
    </div>
</div>
@endsection