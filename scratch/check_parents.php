<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\User;
use App\Models\Parents;

echo "--- USERS WITH PARENT ROLE ---\n";
$users = User::role('parent')->get();
foreach ($users as $user) {
    $parent = Parents::where('user_id', $user->id)->first();
    $studentCount = $parent ? $parent->students()->count() : 0;
    echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Has Parent Record: " . ($parent ? 'YES' : 'NO') . ", Students: {$studentCount}\n";
}
