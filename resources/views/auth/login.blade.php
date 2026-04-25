<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  @include('partials._head')
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
  <div class="w-full max-w-md">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
      <div class="p-8">
        <div class="flex items-center space-x-2 mb-8 justify-center">
          <div class="w-10 h-10 bg-indigo-500 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
          </div>
          <span class="text-2xl font-bold tracking-tight text-slate-900 uppercase">AccaFlow</span>
        </div>

        <div class="text-center mb-8">
          <h1 class="text-xl font-bold text-slate-900">Selamat Datang Kembali</h1>
          <p class="text-slate-500 text-sm">Masuk untuk mengelola dokumen akademik Anda.</p>
        </div>

        @if($errors->any())
          <div class="mb-4 p-4 bg-red-50 border border-red-100 text-red-600 text-sm rounded-xl">
            {{ $errors->first() }}
          </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
          @csrf
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" name="email" required placeholder="admin@accaflow.com" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
          </div>
          <div class="flex items-center justify-end pt-2">
            {{-- <label class="flex items-center">
              <input type="checkbox" name="remember" class="w-4 h-4 text-indigo-500 border-slate-300 rounded focus:ring-indigo-500">
              <span class="ml-2 text-xs text-slate-500">Ingat saya</span>
            </label> --}}
            <a href="#" class="text-xs font-semibold text-indigo-500 hover:text-indigo-600">Lupa password?</a>
          </div>
          <div class="gap-3 flex flex-col items-center">
            <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-indigo-200 mt-4 cursor-pointer">
              Masuk Sekarang
            </button>
            <p class="text-sm text-slate-600">Belum memiliki akun mahasiswa? <a href="{{ route('register') }}" class="font-bold text-indigo-500 hover:text-indigo-600 transition-colors">Daftar di sini</a></p>
          </div>
        </form>
      </div>
      <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 text-center space-y-3">
        <p class="text-xs text-slate-400">Staf atau Dosen? <a href="#" class="font-semibold text-slate-500 hover:text-indigo-500 transition-colors">Hubungi Administrator</a></p>
      </div>
    </div>
    <p class="text-center mt-8 text-slate-400 text-xs">© 2026 AccaFlow. All rights reserved.</p>
  </div>
</body>
</html>
