<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

foreach (User::with('role')->get() as $user) {
    echo $user->email . ' - ' . ($user->role->name ?? 'NO ROLE') . PHP_EOL;
}
