@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
  <div class="flex items-center space-x-4 mb-8">
    <a href="{{ route('documents.index') }}" class="p-2 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-indigo-500 transition-colors">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <div>
      <h1 class="text-2xl font-bold text-slate-900">{{ $document->title }}</h1>
      <p class="text-slate-500 text-sm">ID Pengajuan: ACCA-{{ str_pad($document->id, 5, '0', STR_PAD_LEFT) }}</p>
    </div>
  </div>

  <!-- Progress Stepper -->
  <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm mb-8">
    <div class="relative">
      <div class="absolute top-5 left-0 w-full h-0.5 bg-slate-100 z-0"></div>
      <div class="relative flex justify-between z-10">
        @php
          $steps = [
            1 => ['name' => 'Diajukan', 'status' => 'submitted'],
            2 => ['name' => 'Verifikasi Admin', 'status' => 'verified'],
            3 => ['name' => 'Stempel Digital Prodi', 'status' => 'approved'],
            4 => ['name' => 'Penandatanganan', 'status' => 'signed'],
          ];
          $currentStep = $document->current_step;
          if ($document->status === 'rejected') $currentStep = 0;
        @endphp

        @foreach($steps as $stepNum => $step)
          <div class="flex flex-col items-center">
            <div class="w-10 h-10 rounded-full flex items-center justify-center border-4 border-white shadow-sm {{ $currentStep >= $stepNum ? 'bg-indigo-500 text-white' : 'bg-slate-200 text-slate-500' }}">
              @if($currentStep > $stepNum)
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
              @else
                <span class="font-bold text-sm">{{ $stepNum }}</span>
              @endif
            </div>
            <span class="mt-2 text-xs font-bold {{ $currentStep >= $stepNum ? 'text-indigo-500' : 'text-slate-400' }}">{{ $step['name'] }}</span>
          </div>
        @endforeach
      </div>
    </div>
    
    @if($document->status === 'rejected')
      <div class="mt-6 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center space-x-3">
        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <p class="text-sm text-red-700 font-medium">Dokumen ini telah ditolak. Silakan periksa riwayat untuk melihat alasan penolakan.</p>
      </div>
    @endif
  </div>

  <div class="space-y-8">
    <!-- Detail Dokumen -->
    <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
      <h3 class="text-lg font-bold text-slate-900 mb-6">Detail Dokumen</h3>
      <div>
        <dl class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div>
            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pengirim</dt>
            <dd class="text-sm font-semibold text-slate-900">{{ $document->user->name }}</dd>
          </div>
          <div>
            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jenis Surat</dt>
            <dd class="text-sm font-semibold text-slate-900">{{ ucfirst(str_replace('_', ' ', $document->type)) }}</dd>
          </div>
          <div>
            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dosen Tujuan</dt>
            <dd class="text-sm font-semibold text-slate-900">{{ $document->targetLecturer->name ?? '-' }}</dd>
          </div>
          <div>
            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Terakhir</dt>
            <dd class="mt-1">
              <span class="px-3 py-1 bg-indigo-50 text-indigo-500 border border-indigo-100 rounded-full text-xs font-bold uppercase">
                {{ $document->status }}
              </span>
            </dd>
          </div>
        </dl>
        <div class="mb-4">
          <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider">File Dokumen</dt>
          <dd class="mt-1 flex flex-wrap gap-3">
            @if($document->stamped_file_path)
              <a href="{{ route('documents.download-stamped', $document) }}" class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 bg-blue-50 px-3 py-1.5 rounded-lg transition-colors cursor-pointer">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Stamped
              </a>
            @endif
            <a href="{{ route('documents.download', $document) }}" class="inline-flex items-center text-sm font-bold text-emerald-500 hover:text-emerald-600 bg-indigo-50 px-3 py-1.5 rounded-lg transition-colors">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
              Unduh File Original
            </a>
            @if($document->signed_file_path)
              <a href="{{ route('documents.download-signed', $document) }}" class="inline-flex items-center text-sm font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg transition-colors cursor-pointer">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Signed
              </a>
            @endif
            <button id="toggle-preview" class="inline-flex items-center text-sm font-bold text-slate-600 hover:text-indigo-600 bg-slate-100 px-3 py-1.5 rounded-lg transition-colors cursor-pointer">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
              Pratinjau
            </button>
          </dd>
        </div>
      </div>
    </div>

    <!-- Preview Container -->
    <div id="preview-container" class="hidden mt-8 border-2 border-slate-100 rounded-3xl overflow-hidden bg-slate-50">
      <div class="p-4 bg-white border-b border-slate-100 flex items-center justify-between">
        <span class="text-xs font-bold text-slate-500 uppercase">Pratinjau Dokumen</span>
        <button id="close-preview" class="text-slate-400 hover:text-red-500 cursor-pointer">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
      </div>
      <div class="aspect-16/10 w-full flex items-center justify-center p-4">
        @php
          $previewFile = $document->signed_file_path ?: ($document->stamped_file_path ?: $document->file_path);
        @endphp
        @if(Str::endsWith(strtolower($previewFile), '.pdf'))
          <iframe src="{{ route('documents.preview', $document) }}" class="w-full h-full rounded-xl shadow-inner" frameborder="0"></iframe>
        @else
          <img src="{{ route('documents.preview', $document) }}" class="max-w-full max-h-full rounded-xl shadow-lg object-contain">
        @endif
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
      <!-- Left: Actions -->
      <div class="lg:col-span-2 space-y-8">
        @if(Auth::user()->role->name !== 'student')
          @php
            $roleName = Auth::user()->role->name;
          @endphp
          <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm border-l-4 border-l-indigo-500">
            <h3 class="text-lg font-bold text-slate-900 mb-6">Tindakan Admin</h3>
            <form action="{{ route('documents.update-status', $document) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PATCH')
              <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan/Komentar (Opsional)</label>
                <textarea name="comment" rows="3" class="w-full h-50 px-4 py-3 bg-slate-100 border border-slate-200 rounded-2xl outline-0 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm resize-none" placeholder="Tulis catatan jika diperlukan..."></textarea>
              </div>

              @if(($roleName === 'dosen' || $roleName === 'super_admin') && $document->status === 'approved')
                <div class="mb-6 p-4 bg-indigo-50 border border-indigo-100 rounded-2xl">
                  <label class="block text-sm font-bold text-slate-700 mb-2">Unggah Dokumen Ter-Tanda Tangan</label>
                  <input type="file" name="signed_file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:cursor-pointer file:font-bold file:bg-indigo-100 file:text-indigo-500 hover:file:bg-indigo-200 transition-all" required>
                  <p class="mt-2 text-xs text-stone-500">Silakan unggah dokumen hasil tanda tangan basah/digital di sini untuk menyelesaikan pengajuan.</p>
                </div>
              @endif
              
              <div class="flex flex-wrap items-center item gap-4">
                @if(($roleName === 'admin' || $roleName === 'super_admin') && $document->status === 'submitted')
                  <button type="submit" name="status" value="verified" class="px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-indigo-200 cursor-pointer">Verifikasi Berkas</button>
                @endif

                @if(($roleName === 'kaprodi' || $roleName === 'admin' || $roleName === 'super_admin') && $document->status === 'verified')
                  <div class="w-full mb-6 p-4 bg-indigo-50 border border-indigo-100 rounded-2xl">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Unggah Dokumen Ber-Stempel</label>
                    <input type="file" name="stamped_file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:cursor-pointer file:font-bold file:bg-indigo-100 file:text-indigo-500 hover:file:bg-indigo-200 transition-all" required>
                    <p class="mt-2 text-xs text-stone-500">Silakan unggah dokumen yang sudah dibubuhi stempel prodi di sini.</p>
                  </div>
                @endif

                @if(($roleName === 'dosen' || $roleName === 'super_admin') && $document->status === 'approved')
                  <button type="submit" name="status" value="signed" class="px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-indigo-200 cursor-pointer">Tanda Tangani & Unggah</button>
                @endif

                @if(($roleName === 'kaprodi' || $roleName === 'admin' || $roleName === 'super_admin') && $document->status === 'verified')
                  <button type="submit" name="status" value="approved" class="px-6 py-1 h-12 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-indigo-200 cursor-pointer">Beri Stempel Digital</button>
                @endif

                @if($document->status !== 'rejected' && $document->status !== 'signed')
                  <button type="submit" name="status" value="rejected" class="px-6 py-3 bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-500 font-bold rounded-2xl transition-all duration-300 border border-red-100 cursor-pointer">Tolak Dokumen</button>
                @endif
              </div>
            </form>

            @if(($roleName === 'admin' || $roleName === 'super_admin') && $document->status !== 'submitted')
              <div class="mt-4 pt-4 border-t border-slate-100">
                <form action="{{ route('documents.revert', $document) }}" method="POST" class="inline">
                  @csrf
                  <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mengembalikan progres dokumen ke tahap sebelumnya?')" class="text-sm font-bold text-amber-600 hover:text-amber-700 transition-colors flex items-center cursor-pointer">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                    Kembalikan ke Tahap Sebelumnya (Revert)
                  </button>
                </form>
              </div>
            @endif
          </div>
        @else
          <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
              <h4 class="font-bold text-slate-900">Status Pengajuan</h4>
              <p class="text-sm text-slate-500">Dokumen Anda sedang diproses. Pantau riwayat aktivitas di sebelah kanan untuk pembaruan terkini.</p>
            </div>
          </div>
        @endif

        @if($document->status === 'signed' && $document->verification_hash)
          <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-8">
            <div class="p-3 bg-white border-2 border-slate-100 rounded-3xl shadow-sm">
              <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ route('verify', $document->verification_hash) }}" alt="Verification QR Code">
            </div>
            <div class="flex-1 text-center md:text-left">
              <h4 class="font-bold text-slate-900 mb-1">Verifikasi Digital Aktif</h4>
              <p class="text-sm text-slate-500 mb-4">Pihak ketiga dapat memindai kode di atas untuk memvalidasi keaslian dokumen ini tanpa perlu login.</p>
              <div class="inline-flex items-center space-x-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-xs font-bold uppercase">Dokumen Sah</span>
              </div>
            </div>
          </div>
        @endif
      </div>

      <!-- Right: Timeline / Audit Trail -->
      <div class="lg:col-span-1">
        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
          <h3 class="text-lg font-bold text-slate-900 mb-6">Riwayat Aktivitas</h3>
          <div class="relative space-y-6 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
            <div class="absolute top-2 left-3 w-0.5 h-[calc(100%-16px)] bg-slate-100"></div>
              
            @foreach($document->logs->sortByDesc('created_at') as $log)
              <div class="relative flex space-x-4">
                <div class="w-6 h-6 rounded-full border-4 border-white shadow-sm shrink-0 z-10 
                  {{ in_array($log->action, ['submitted', 'verified', 'approved', 'signed']) ? 'bg-indigo-500' : 'bg-red-500' }}"></div>
                <div>
                  <p class="text-sm font-bold text-slate-900">{{ ucfirst($log->action) }}</p>
                  <p class="text-[11px] text-slate-400 mb-1">{{ $log->created_at->format('d M Y, H:i') }} • {{ $log->user->name }}</p>
                  @if($log->comment)
                    <p class="text-xs text-slate-500 italic bg-slate-50 p-2 rounded-lg border border-slate-100">"{{ $log->comment }}"</p>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="module" src="{{ asset('build/assets/show_js.js') }}"></script>

@endsection