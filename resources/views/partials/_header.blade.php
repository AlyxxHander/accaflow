<!-- Header -->
<header class="bg-white border-b border-slate-200 h-20 flex items-center justify-between px-6 z-40">
  <button id="open-sidebar" class="md:hidden text-slate-600 hover:text-indigo-600 cursor-pointer">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
  </button>
  <form action="{{ route('documents.index') }}" method="GET" class="hidden md:flex items-center bg-slate-100 rounded-full px-4 py-1.5 w-1/2 border border-slate-200">
    <svg class="w-4 h-4 text-slate-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari dokumen atau pengajuan..." class="w-full py-1 bg-transparent border-none outline-0 text-sm">
  </form>
  <div class="gap-4 flex items-center">
    <div class="h-8 w-px bg-slate-300"></div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="text-sm font-semibold text-slate-600 hover:text-red-600 transition-colors cursor-pointer">Keluar</button>
    </form>
  </div>
</header>