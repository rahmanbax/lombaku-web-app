<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // Untuk judul kolom
use Maatwebsite\Excel\Concerns\WithMapping;  // Untuk memformat setiap baris
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Untuk ukuran kolom otomatis

class MahasiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Ambil data yang sama persis seperti di dashboard Anda
        return User::where('role', 'mahasiswa')
            ->with('profilMahasiswa.programStudi')
            ->withCount([
                'registrasiLomba',
                'prestasi' => function ($query) {
                    $query->where('status_verifikasi', 'disetujui');
                }
            ])
            ->orderBy('nama', 'asc')
            ->get();
    }

    /**
     * Mendefinisikan judul kolom untuk file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'NIM',
            'Email',
            'Program Studi',
            'Lomba Diikuti',
            'Jumlah Prestasi',
        ];
    }

    /**
     * Memetakan data dari setiap user menjadi baris di Excel.
     *
     * @param mixed $mahasiswa
     * @return array
     */
    public function map($mahasiswa): array
    {
        return [
            $mahasiswa->nama,
            $mahasiswa->profilMahasiswa->nim ?? 'N/A', // Handle jika profil belum ada
            $mahasiswa->email,
            $mahasiswa->profilMahasiswa->programStudi->nama_program_studi ?? 'N/A',
            $mahasiswa->registrasi_lomba_count,
            $mahasiswa->prestasi_count,
        ];
    }
}