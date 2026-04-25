<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  @include('partials._head')
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
  <div class="w-full max-w-2xl">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
      <div class="p-8">
        <div class="flex items-center space-x-2 mb-8 justify-center">
          <div class="w-10 h-10 bg-indigo-500 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
          </div>
          <span class="text-2xl font-bold tracking-tight text-slate-900 uppercase">AccaFlow</span>
        </div>

        <div class="text-center mb-8">
          <h1 class="text-xl font-bold text-slate-900">Pendaftaran Mahasiswa</h1>
          <p class="text-slate-500 text-sm">Lengkapi data diri Anda untuk membuat akun.</p>
        </div>

        @if($errors->any())
          <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-600 text-sm rounded-xl">
            <ul class="list-disc list-inside">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
          @csrf
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Lengkap -->
            <div class="md:col-span-2">
              <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap Mahasiswa</label>
              <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Muhammad Akhyar" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
            </div>

            <!-- NIM -->
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">NIM</label>
              <input type="text" name="nim" value="{{ old('nim') }}" required placeholder="202010370311190" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
            </div>

            <!-- Email UMM -->
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Email UMM (@webmail.umm.ac.id)</label>
              <input type="email" name="email" value="{{ old('email') }}" required placeholder="emailumm@webmail.umm.ac.id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
            </div>

            <!-- Jurusan -->
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Jurusan</label>
              <input type="text" name="department" value="{{ old('department') }}" required placeholder="Teknik" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
            </div>

            <!-- Program Studi -->
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Program Studi</label>
              <input type="text" name="study_program" value="{{ old('study_program') }}" required placeholder="Informatika" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
            </div>

            <!-- Password -->
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
              <input type="password" name="password" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
            </div>

            <!-- Confirm Password -->
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
            </div>
          </div>

          <div class="pt-4">
            <button type="submit" class="w-full py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-200">
              Daftar Sekarang
            </button>
          </div>
        </form>

        <div class="mt-8 text-center border-t border-slate-100 pt-8">
          <p class="text-slate-500 text-sm">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-indigo-500 font-bold hover:text-indigo-600 transition-colors">Masuk di sini</a></p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
