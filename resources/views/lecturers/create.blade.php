@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="mb-8">
    <a href="{{ route('lecturers.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-indigo-600 transition-colors mb-4">
      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
      Kembali ke Daftar Dosen
    </a>
    <h1 class="text-2xl font-bold text-slate-900">Tambah Akun Dosen</h1>
    <p class="text-slate-500">Buat akun dosen baru dengan informasi lengkap.</p>
  </div>

  @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">
      <ul class="list-disc list-inside text-sm text-red-600">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <form action="{{ route('lecturers.store') }}" method="POST" class="p-8 space-y-6">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="col-span-1 md:col-span-2">
          <label class="block text-sm font-semibold text-slate-700 mb-2"><span class="text-red-500">* </span>Nama Lengkap & Gelar</label>
          <input type="text" name="name" required value="{{ old('name') }}" placeholder="Contoh: Dr. Azka Ryan, S.Kom., M.T." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2"><span class="text-red-500">* </span>NIDN / NIP</label>
          <input type="text" name="nidn_nip" required value="{{ old('nidn_nip') }}" placeholder="Unique Identifier" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2"><span class="text-red-500">* </span>Email Institusi</label>
          <input type="email" name="email" required value="{{ old('email') }}" placeholder="username@webmail.umm.ac.id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2"><span class="text-red-500">* </span>Jabatan Struktural</label>
          <select name="structural_position" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
            <option value="" disabled selected>Pilih Jabatan</option>
            <option value="Dosen" {{ old('structural_position') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
            <option value="Kaprodi" {{ old('structural_position') == 'Kaprodi' ? 'selected' : '' }}>Kaprodi</option>
            <option value="Sekprodi" {{ old('structural_position') == 'Sekprodi' ? 'selected' : '' }}>Sekprodi</option>
            <option value="Dekan" {{ old('structural_position') == 'Dekan' ? 'selected' : '' }}>Dekan</option>
          </select>
        </div>

        <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2"><span class="text-red-500">* </span>Password</label>
            <input type="password" name="password" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2"><span class="text-red-500">* </span>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
          </div>
        </div>
      </div>

      <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-4">
        <a href="{{ route('lecturers.index') }}" class="px-6 py-3 text-sm font-bold text-slate-600 hover:text-slate-900 transition-colors cursor-pointer">Batal</a>
        <button type="submit" class="px-8 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-200 cursor-pointer">
          Simpan Akun
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
