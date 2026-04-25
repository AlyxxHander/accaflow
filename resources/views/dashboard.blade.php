@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
  <div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Selamat Datang, {{ Auth::user()->name }}!</h1>
    <p class="text-slate-500">Berikut adalah ringkasan aktivitas dokumen Anda hari ini.</p>
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

  <!-- Recent Activity -->
  {{-- <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
      <h2 class="font-bold text-slate-900">Aktivitas Terakhir</h2>
      <a href="#" class="text-xs font-semibold text-indigo-500 hover:text-indigo-600">Lihat Semua</a>
    </div>
    <div class="p-6">
      <div class="flex flex-col items-center justify-center py-12 text-slate-400">
        <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
        <p class="text-sm">Belum ada aktivitas pengajuan dokumen.</p>
      </div>
    </div>
  </div> --}}
</div>
@endsection
