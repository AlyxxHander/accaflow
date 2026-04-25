@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
  <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-900">Manajemen Dosen</h1>
      <p class="text-slate-500">Kelola akun dosen dan pejabat struktural prodi.</p>
    </div>
    <a href="{{ route('lecturers.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-200">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
      Tambah Dosen
    </a>
  </div>

  <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-100 border-b border-slate-100">
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama & Gelar</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">NIDN / NIP</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Email</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jabatan</th>
            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($lecturers as $lecturer)
          <tr class="hover:bg-slate-50 transition-colors">
            <td class="px-6 py-4 font-semibold text-slate-900">{{ $lecturer->name }}</td>
            <td class="px-6 py-4 text-sm text-slate-600">{{ $lecturer->nidn_nip ?? '-' }}</td>
            <td class="px-6 py-4 text-sm text-slate-600">{{ $lecturer->email }}</td>
            <td class="px-6 py-4">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700">
                {{ $lecturer->structural_position }}
              </span>
            </td>
            <td class="px-6 py-4 text-right">
              <div class="flex items-center justify-end space-x-2">
                <a href="{{ route('lecturers.edit', $lecturer) }}" class="p-2 text-slate-400 hover:text-indigo-500 hover:bg-indigo-50 rounded-lg transition-all cursor-pointer">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </a>
                <form action="{{ route('lecturers.destroy', $lecturer) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun dosen ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
              <p class="text-sm">Belum ada data dosen.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
