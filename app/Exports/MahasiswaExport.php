<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

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
                // Hitung semua lomba yang pernah didaftarkan
                'registrasiLomba', 
                
                // Hitung semua prestasi yang disetujui
                'prestasi as total_prestasi' => function ($query) {
                    $query->where('status_verifikasi', 'disetujui');
                },
                
                // [TAMBAHAN] Hitung prestasi dengan tipe 'pemenang'
                'prestasi as juara_count' => function ($query) {
                    $query->where('status_verifikasi', 'disetujui')
                          ->where('tipe_prestasi', 'pemenang');
                },

                // [TAMBAHAN] Hitung prestasi dengan tipe 'peserta'
                'prestasi as peserta_count' => function ($query) {
                    $query->where('status_verifikasi', 'disetujui')
                          ->where('tipe_prestasi', 'peserta');
                }
            ])
            ->orderBy('nama', 'asc')
            ->get();
    }

    /**
     * Mendefinisikan judul kolom untuk file Excel.
     */
    public function headings(): array
    {
        // [PERUBAHAN] Tambahkan judul kolom baru
        return [
            'Nama Mahasiswa',
            'NIM',
            'Email',
            'Program Studi',
            'Total Lomba Diikuti',
            'Total Prestasi (Disetujui)',
            'Jumlah Prestasi sbg Juara',
            'Jumlah Prestasi sbg Peserta',
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
        // [PERUBAHAN] Tambahkan data baru ke dalam array baris
        return [
            $mahasiswa->nama,
            $mahasiswa->profilMahasiswa->nim ?? 'N/A',
            $mahasiswa->email,
            $mahasiswa->profilMahasiswa->programStudi->nama_program_studi ?? 'N/A',
            $mahasiswa->registrasi_lomba_count,
            $mahasiswa->total_prestasi, // Menggunakan alias dari withCount
            $mahasiswa->juara_count,   // Menggunakan alias dari withCount
            $mahasiswa->peserta_count, // Menggunakan alias dari withCount
        ];
    }
}