<!-- Sidebar -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transition-transform duration-300 transform md:relative md:translate-x-0 -translate-x-full">
  <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800">
    <div class="flex items-center space-x-2">
      <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
      </div>
      <span class="text-xl font-bold tracking-tight">AccaFlow</span>
    </div>
    <button id="close-sidebar" class="md:hidden text-slate-400 hover:text-white cursor-pointer">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
  </div>

  <nav class="mt-6 px-4 space-y-1">
    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-colors">
      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 011-1h12a1 1 0 011 1V10M5 10l7-7 7 7"></path></svg>
      Dashboard
    </a>
    <a href="{{ route('documents.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('documents.*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-colors">
      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
      Lacak Dokumen
    </a>

    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('super_admin'))
    <a href="{{ route('lecturers.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('lecturers.*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-colors">
      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
      Manajemen Dosen
    </a>
    @endif
  </nav>
  
  <div class="absolute bottom-0 w-full p-4 border-t border-slate-800">
    <div class="flex items-center px-4 py-2 space-x-3 rounded-xl hover:bg-slate-800 cursor-pointer transition-colors">
      <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center font-bold text-xs">
        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
      </div>
      <div class="flex-1 overflow-hidden text-ellipsis whitespace-nowrap">
        <p class="text-sm font-semibold text-white">{{ Auth::user()->name ?? 'User' }}</p>
        <p class="text-xs text-slate-500">{{ Auth::user()->role->display_name ?? 'Role' }}</p>
      </div>
    </div>
  </div>
</aside>