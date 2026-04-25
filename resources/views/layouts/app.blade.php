<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  @include('partials._head')
</head>
<body class="bg-slate-50 text-slate-900">
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    @include('partials._sidebar')
    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Header -->
      @include('partials._header')
      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto bg-slate-100 p-6">
        @yield('content')
      </main>
    </div>
  </div>
</body>
</html>
