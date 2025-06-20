@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="ml-64 p-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
    
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500">Lomba Aktif</h3>
            <p class="text-3xl font-bold">{{ $activeLombas ?? 0 }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500">Total Peserta</h3>
            <p class="text-3xl font-bold">{{ $totalParticipants ?? 0 }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500">Dokumen Tertunda</h3>
            <p class="text-3xl font-bold">{{ $pendingDocuments ?? 0 }}</p>
        </div>
    </div>

    <!-- Recent Lombas -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Daftar Lomba Terkini</h2>
        
        @if(isset($recentLombas) && $recentLombas->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lomba</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Deadline</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Peserta</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentLombas as $lomba)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $lomba->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $lomba->registration_end->format('d F Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $lomba->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $lomba->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                {{ $lomba->participants->count() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 py-4">Belum ada data lomba</p>
        @endif
    </div>
</div>
@endsection