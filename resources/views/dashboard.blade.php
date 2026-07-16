@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto relative">
  <div class="mb-8 flex justify-between items-start">
    <div>
      <h1 class="text-2xl font-bold text-slate-900">Selamat Datang, {{ Auth::user()->name }}!</h1>
      <p class="text-slate-500">Berikut adalah ringkasan aktivitas dokumen Anda hari ini.</p>
    </div>
    
    @php
      $notifCount = 0;
      if(isset($stats['overdue']) && Auth::user()->role->name !== 'student') $notifCount += $stats['overdue'];
      if(isset($actionReminders) && Auth::user()->role->name !== 'student') $notifCount += $actionReminders->count();
      if(isset($studentReminders) && Auth::user()->role->name === 'student') $notifCount += $studentReminders->count();
    @endphp

    <div class="relative">
      <button id="notif-btn" class="relative p-3 bg-white border border-slate-200 rounded-full text-slate-500 hover:text-indigo-600 hover:bg-slate-50 transition-colors shadow-sm focus:outline-none cursor-pointer">
        <i class="fa-solid fa-bell text-xl"></i>
        @if($notifCount > 0)
          <span class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -mt-1 -mr-1">
            {{ $notifCount }}
          </span>
        @endif
      </button>

      <!-- Notification Dropdown -->
      <div id="notif-dropdown" class="hidden absolute right-0 mt-3 w-80 sm:w-96 bg-white border border-slate-200 rounded-2xl shadow-2xl z-50 overflow-hidden flex-col">
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
          <h3 class="font-bold text-slate-800">Notifikasi</h3>
          <span class="text-xs bg-indigo-100 text-indigo-600 font-bold px-2 py-1 rounded-full">{{ $notifCount }} Baru</span>
        </div>
        
        <div class="max-h-96 overflow-y-auto p-4 space-y-4 custom-scrollbar">
          @if($notifCount == 0)
            <div class="text-center py-6 text-slate-400">
              <i class="fa-regular fa-bell-slash text-3xl mb-2"></i>
              <p class="text-sm">Tidak ada notifikasi baru.</p>
            </div>
          @else
            <!-- Overdue Indicator -->
            @if(isset($stats['overdue']) && $stats['overdue'] > 0 && Auth::user()->role->name !== 'student')
              <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                <div class="flex items-start">
                  <div class="flex-shrink-0 mt-0.5">
                    <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                  </div>
                  <div class="ml-3">
                    <h4 class="text-sm font-bold text-red-800">Overdue ({{ $stats['overdue'] }})</h4>
                    <p class="text-[11px] text-red-700 mt-1">Belum diproses > 2 hari.</p>
                    <div class="mt-3 space-y-2">
                      @foreach($overdueDocuments as $doc)
                        <a href="{{ route('documents.show', $doc) }}" class="block px-3 py-2 bg-white rounded-lg text-xs text-red-600 border border-red-100 hover:border-red-300">
                          <span class="font-bold">{{ $doc->title }}</span><br>
                          <span class="text-red-400">Dari: {{ $doc->user->name }}</span>
                        </a>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            @endif

            <!-- Staff Action Reminders -->
            @if(isset($actionReminders) && $actionReminders->count() > 0 && Auth::user()->role->name !== 'student')
              <div class="bg-amber-50 border border-amber-200 p-4 rounded-xl">
                <div class="flex items-start mb-3">
                  <div class="mt-0.5">
                    <i class="fa-solid fa-clipboard-list text-amber-500"></i>
                  </div>
                  <div class="ml-3">
                    <h4 class="text-sm font-bold text-amber-900">Perlu Tindakan ({{ $actionReminders->count() }})</h4>
                  </div>
                </div>
                <div class="space-y-2">
                  @foreach($actionReminders as $doc)
                    <a href="{{ route('documents.show', $doc) }}" class="block px-3 py-2 bg-white rounded-lg text-xs border border-amber-100 hover:shadow-sm">
                      <span class="font-bold text-slate-800">{{ $doc->title }}</span><br>
                      <span class="text-slate-500">Pengaju: {{ $doc->user->name }}</span>
                    </a>
                  @endforeach
                </div>
              </div>
            @endif

            <!-- Student Approved Reminders -->
            @if(isset($studentReminders) && $studentReminders->count() > 0 && Auth::user()->role->name === 'student')
              <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-xl">
                <div class="flex items-start mb-3">
                  <div class="mt-0.5">
                    <i class="fa-solid fa-check-circle text-emerald-500"></i>
                  </div>
                  <div class="ml-3">
                    <h4 class="text-sm font-bold text-emerald-900">Selesai Diproses ({{ $studentReminders->count() }})</h4>
                  </div>
                </div>
                <div class="space-y-2">
                  @foreach($studentReminders as $doc)
                    <a href="{{ route('documents.show', $doc) }}" class="block px-3 py-2 bg-white rounded-lg text-xs border border-emerald-100 hover:shadow-sm">
                      <span class="font-bold text-slate-800">{{ $doc->title }}</span><br>
                      <span class="text-slate-500">Selesai: {{ $doc->updated_at->format('d M Y, H:i') }}</span>
                    </a>
                  @endforeach
                </div>
              </div>
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>

    <!-- Stats Grid -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
      <div class="flex items-center justify-between mb-4">
        <div class="w-10 h-10 bg-indigo-100 text-indigo-500 rounded-lg flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <span class="text-xs font-medium text-slate-400">Total Pengajuan</span>
      </div>
      <p class="text-3xl font-bold text-slate-900">{{ $stats['total'] }}</p>
      <p class="text-xs text-slate-500 mt-1">Dokumen diajukan</p>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
      <div class="flex items-center justify-between mb-4">
        <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <span class="text-xs font-medium text-slate-400">Dalam Proses</span>
      </div>
      <p class="text-3xl font-bold text-slate-900">{{ $stats['pending'] }}</p>
      <p class="text-xs text-slate-500 mt-1">Menunggu verifikasi</p>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
      <div class="flex items-center justify-between mb-4">
        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <span class="text-xs font-medium text-slate-400">Selesai</span>
      </div>
      <p class="text-3xl font-bold text-slate-900">{{ $stats['completed'] }}</p>
      <p class="text-xs text-slate-500 mt-1">Dokumen terbit</p>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const btn = document.getElementById('notif-btn');
      const dropdown = document.getElementById('notif-dropdown');
      
      btn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            dropdown.classList.add('flex');
        } else {
            dropdown.classList.add('hidden');
            dropdown.classList.remove('flex');
        }
      });
      
      document.addEventListener('click', function(e) {
        if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
          dropdown.classList.add('hidden');
          dropdown.classList.remove('flex');
        }
      });
    });
  </script>
</div>
@endsection
