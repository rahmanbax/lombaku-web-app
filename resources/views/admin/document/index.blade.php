@extends('admin.layouts.app')

@section('title', 'Verifikasi Dokumen')

@section('content')
<div class="ml-64 p-6">
    <h1 class="text-2xl font-bold mb-6">Verifikasi Dokumen Peserta</h1>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Peserta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lomba</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($documents as $document)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $document->participant->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $document->participant->lomba->title ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($document->document_path)
                            <a href="{{ asset('storage/'.$document->document_path) }}" 
                               target="_blank"
                               class="text-blue-600 hover:underline">
                                Lihat Dokumen
                            </a>
                            @else
                            Tidak ada dokumen
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $document->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                                   ($document->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $document->status === 'accepted' ? 'Diterima' : 
                                   ($document->status === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.documents.update', $document->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="flex space-x-2">
                                    <button type="submit" name="status" value="accepted" 
                                            class="text-green-600 hover:text-green-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                    <button type="submit" name="status" value="rejected" 
                                            class="text-red-600 hover:text-red-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <input type="text" name="rejection_reason" placeholder="Alasan (jika ditolak)" 
                                       class="mt-1 text-xs border rounded p-1 w-full"
                                       value="{{ $document->rejection_reason }}">
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada dokumen yang perlu diverifikasi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            {{ $documents->links() }}
        </div>
    </div>
</div>
@endsection