<!DOCTYPE html>
<html lang="id">
<head>
  @include('partials._head')
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
  <div class="w-full max-w-2xl">
    <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-200 overflow-hidden">
      <!-- Header -->
      <div class="bg-slate-900 p-8 text-center text-white">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-white/10 rounded-2xl mb-4 backdrop-blur-sm">
          <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
        </div>
        <h1 class="text-2xl font-bold">Pelacakan Resi Dokumen</h1>
        <p class="text-slate-400 text-sm">Pembaruan status secara real-time</p>
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
          <div class="space-y-1 md:col-span-2">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pengirim / Mahasiswa</p>
            <p class="text-lg font-bold text-slate-900">{{ $document->user->name }}</p>
          </div>
        </div>

        <div class="mb-8">
            <h3 class="font-bold text-slate-900 mb-6">Status Saat Ini: <span class="px-3 py-1 bg-indigo-50 text-indigo-500 rounded-full text-sm uppercase">{{ $document->status }}</span></h3>
            
            <div class="relative space-y-6">
                <div class="absolute top-2 left-3 w-0.5 h-[calc(100%-16px)] bg-slate-100"></div>
                
                @foreach($document->logs->sortByDesc('created_at') as $log)
                <div class="relative flex space-x-4">
                    <div class="w-6 h-6 rounded-full border-4 border-white shadow-sm shrink-0 z-10 
                    {{ in_array($log->action, ['submitted', 'verified', 'approved', 'signed']) ? 'bg-indigo-500' : 'bg-red-500' }}"></div>
                    <div>
                    <p class="text-sm font-bold text-slate-900">{{ ucfirst($log->action) }}</p>
                    <p class="text-[11px] text-slate-400 mb-1">{{ $log->created_at->format('d M Y, H:i') }} • {{ $log->user->name }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

      </div>

      <!-- Footer -->
      <div class="p-8 border-t border-slate-100 bg-slate-50/50 text-center">
        <a href="{{ route('login') }}" class="inline-flex items-center space-x-2 text-sm font-bold text-indigo-500 hover:text-indigo-600">
          <span>Masuk ke AccaFlow</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </a>
      </div>
    </div>
  </div>

  <script type="module" src="{{ asset('build/assets/app.js') }}"></script>

</body>
</html>
