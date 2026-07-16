@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
  <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-900">Pelacakan Dokumen</h1>
      <p class="text-slate-500">Lihat status dan riwayat pengajuan dokumen Anda.</p>
    </div>
    <a href="{{ route('documents.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-200">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
      Ajukan Dokumen
    </a>
  </div>

  <!-- Status Filter -->
  <div class="flex flex-wrap gap-2 mb-6">
    @php
      $currentStatus = request('status');
      $statusLabels = [
        'submitted' => 'Diajukan',
        'verified' => 'Terverifikasi',
        'approved' => 'Stempel Prodi',
        'signed' => 'Selesai/TTD',
        'rejected' => 'Ditolak',
      ];
      $statusClasses = [
        'submitted' => 'bg-blue-50 text-blue-600 border-blue-100',
        'verified' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
        'approved' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
        'rejected' => 'bg-red-50 text-red-600 border-red-100',
        'signed' => 'bg-purple-50 text-purple-600 border-purple-100',
      ];
      $statuses = [null => 'Semua'] + $statusLabels;
    @endphp

    @foreach($statuses as $value => $label)
      <a href="{{ route('documents.index', $value ? ['status' => $value] : []) }}" 
        class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ $currentStatus == $value ? 'bg-indigo-500 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-indigo-300 hover:text-indigo-600' }}">
        {{ $label }}
      </a>
    @endforeach
  </div>

  <form id="bulk-delete-form" action="{{ route('documents.bulk-destroy') }}" method="POST">
    @csrf
    @method('DELETE')
    
    <div id="bulk-actions" class="hidden mb-6 items-center justify-between p-4 bg-white border border-red-100 rounded-3xl shadow-sm">
      <div class="flex items-center space-x-3">
        <div class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </div>
        <div>
          <p class="text-sm font-bold text-slate-900"><span id="selected-count">0</span> Dokumen Terpilih</p>
          <p class="text-xs text-slate-500">Tindakan ini tidak dapat dibatalkan</p>
        </div>
      </div>
      <button type="button" id="bulk-delete-confirm" class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-bold rounded-2xl text-sm transition-all shadow-lg shadow-red-100 cursor-pointer">
        Hapus Permanen
      </button>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-slate-100 border-b border-slate-100">
              <th class="pl-6 py-4 w-10">
                <input type="checkbox" id="select-all" class="w-4 h-4 text-indigo-500 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer">
              </th>
              <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Dokumen</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pengirim</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Dosen Tujuan</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @php
              $userRole = Auth::user()->role->name;
              $isSuperAdmin = $userRole === 'super_admin';
              $isAdmin = $userRole === 'admin';
            @endphp
            @forelse($documents as $doc)
            @php
              $canDelete = $isSuperAdmin || ($isAdmin && $doc->status === 'rejected');
            @endphp
            <tr class="hover:bg-slate-50 transition-colors">
              <td class="pl-6 py-4">
                @if($canDelete)
                  <input type="checkbox" name="ids[]" value="{{ $doc->id }}" class="doc-checkbox w-4 h-4 text-indigo-500 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer">
                @endif
              </td>
              <td class="px-6 py-4">
                <a href="{{ route('documents.show', $doc) }}" class="font-semibold text-slate-900 hover:text-indigo-500 transition-colors">{{ $doc->title }}</a>
                <p class="text-[10px] text-slate-400">ID: ACCA-{{ str_pad($doc->id, 5, '0', STR_PAD_LEFT) }}</p>
              </td>
              <td class="px-6 py-4">
                <span class="text-sm text-slate-600">{{ $doc->user->name ?? '-' }}</span>
              </td>
              <td class="px-6 py-4">
                <span class="text-sm text-slate-600">{{ ucfirst(str_replace('_', ' ', $doc->type)) }}</span>
              </td>
              <td class="px-6 py-4">
                <span class="text-sm text-slate-600">{{ $doc->targetLecturer->name ?? '-' }}</span>
              </td>
              <td class="px-6 py-4 text-sm text-slate-500">
                {{ $doc->created_at->format('d M Y') }}
              </td>
              <td class="px-6 py-4">
                @php
                  $statusClass = $statusClasses[$doc->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                @endphp
                <div class="flex flex-col space-y-1">
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }} w-fit">
                    {{ $statusLabels[$doc->status] ?? ucfirst($doc->status) }}
                  </span>
                  @if(Auth::user()->role->name !== 'student' && $doc->isOverdue())
                    <span class="inline-flex items-center text-[10px] font-bold text-red-600 uppercase tracking-tighter">
                      <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                      Overdue
                    </span>
                  @endif
                </div>
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end space-x-2">
                  <a href="{{ route('documents.show', $doc) }}" class="p-2 text-slate-400 hover:text-indigo-500 hover:bg-indigo-50 rounded-lg transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                  </a>
                  @if($canDelete)
                    <button type="button" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all delete-single-btn cursor-pointer" data-id="{{ $doc->id }}" data-title="{{ $doc->title }}">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                  @endif
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <p class="text-sm">Belum ada dokumen yang diajukan.</p>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </form>

  <!-- Single Delete Form (Helper) -->
  <form id="single-delete-form" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
  </form>
</div>

<script type="module" src="{{ asset('build/assets/index_js.js') }}"></script>

@endsection
