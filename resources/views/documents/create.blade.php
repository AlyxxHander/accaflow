@extends('layouts.app')

@section('content')
<div class="w-full mx-auto ">
  <div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Ajukan Dokumen Baru</h1>
    <p class="text-slate-500">Silakan lengkapi formulir di bawah untuk memulai proses pengajuan.</p>
  </div>

  <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="col-span-1 md:col-span-2">
          <label class="block text-sm font-semibold text-slate-700 mb-2"><span class="text-red-500">* </span>Judul Pengajuan</label>
          <input type="text" name="title" required placeholder="Contoh: Permohonan Surat Keterangan Mahasiswa Aktif" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2"><span class="text-red-500">* </span>Jenis Dokumen</label>
          <select name="type" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm cursor-pointer">
            <option value="" disabled selected>Pilih Jenis Dokumen</option>
            <option value="surat_aktif">Surat Keterangan Aktif</option>
            {{-- <option value="surat_magang">Surat Pengantar Magang</option>
            <option value="pengajuan_cuti">Pengajuan Cuti</option> --}}
          </select>
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2"><span class="text-red-500">* </span>Dosen Tujuan</label>
          <select name="target_lecturer_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm cursor-pointer">
            <option value="" disabled selected>Pilih Dosen Tujuan</option>
            @foreach($lecturers as $lecturer)
              <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2"><span class="text-red-500">* </span>File Dokumen</label>
          <input type="file" name="file" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 hover:file:cursor-pointer transition-all">
          <p class="text-xs text-slate-400 mt-2"><span class="text-red-500">* </span>Maksimal ukuran file 2MB</p>
        </div>
      </div>

      <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-4">
        <a href="{{ route('dashboard') }}" class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors cursor-pointer">Batal</a>
        <button type="submit" class="px-8 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-200 cursor-pointer">
          Kirim Pengajuan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
