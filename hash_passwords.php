<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$users = User::all();
foreach($users as $u) {
    if (!str_starts_with($u->password, '$2y$')) {
        $u->password = Hash::make($u->password);
        $u->save();
        echo "Hashed password for user: {$u->username}\n";
    }
}
echo "Done.\n";
