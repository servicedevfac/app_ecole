<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::transaction(function() {
    $user = User::create([
        'name' => 'Admin User',
        'email' => 'palmer@example.com',
        'password' => Hash::make('password'),
    ]);
    
    $user->assignRole('Super Admin');
});

echo "super a user created successfully: admin_user@example.com / password\n";
