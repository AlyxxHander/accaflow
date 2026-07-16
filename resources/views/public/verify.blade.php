<!DOCTYPE html>
<html lang="id">
<head>
  @include('partials._head')
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
  <div class="w-full max-w-2xl">
    <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-200 overflow-hidden">
      <!-- Header -->
      <div class="bg-indigo-500 p-8 text-center text-white">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl mb-4 backdrop-blur-sm">
          <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h1 class="text-2xl font-bold">Dokumen Terverifikasi</h1>
        <p class="text-indigo-100 text-sm">Dokumen ini diterbitkan secara resmi oleh Sistem AccaFlow.</p>
      </div>

      <!-- Content -->
      <div class="p-8 md:p-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
          <div class="space-y-1">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Judul Dokumen</p>
            <p class="text-lg font-bold text-slate-900">{{ $document->title }}</p>
          </div>
          <div class="space-y-1">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">ID Pengajuan</p>
            <p class="text-lg font-bold italic text-indigo-500">ACCA-{{ str_pad($document->id, 5, '0', STR_PAD_LEFT) }}</p>
          </div>
          <div class="space-y-1">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Nama Mahasiswa</p>
            <p class="text-lg font-bold text-slate-900">{{ $document->user->name }}</p>
          </div>
          <div class="space-y-1">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Jenis Dokumen</p>
            <p class="text-lg font-bold text-slate-900">{{ ucfirst(str_replace('_', ' ', $document->type)) }}</p>
          </div>
        </div>

        <div class="bg-emerald-50 rounded-3xl p-6 border border-emerald-200 flex items-center space-x-6">
          <div class="w-16 h-16 bg-white rounded-2xl border border-emerald-200 flex items-center justify-center shrink-0">
            <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          </div>
          <div>
            @php
              $approvalLog = $document->logs()->whereIn('action', ['approved', 'signed'])->latest()->first();
              $approverName = $approvalLog ? $approvalLog->user->name : ($signer->name ?? 'Pejabat Berwenang');
              $approverRole = $approvalLog ? ($approvalLog->user->role->name === 'kaprodi' ? 'Kaprodi' : 'Dosen') : '';
              $approvalDate = $approvalLog ? $approvalLog->created_at->format('d F Y') : ($document->updated_at->format('d F Y'));
            @endphp
            <p class="text-lg font-bold text-emerald-700">Dokumen ini ASLI,</p>
            <p class="text-sm text-emerald-600 mt-1">disetujui oleh {{ trim("$approverRole $approverName") }} pada tanggal {{ $approvalDate }}.</p>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="p-8 border-t border-slate-100 bg-slate-50/50 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center space-x-2">
          <div class="w-6 h-6 bg-slate-900 rounded-md flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
          </div>
          <span class="text-sm font-bold tracking-tight text-slate-900 uppercase">AccaFlow</span>
        </div>
        <p class="text-xs text-slate-400 italic">Kode Hash: {{ $document->verification_hash }}</p>
      </div>
    </div>
    <p class="text-center mt-8 text-slate-400 text-xs italic">Verifikasi ini dihasilkan secara otomatis oleh sistem keamanan AccaFlow untuk menjamin keaslian dokumen akademik.</p>
  </div>
</body>
</html>
