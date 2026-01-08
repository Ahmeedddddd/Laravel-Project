<?php
use App\Models\ContactMessage;
use App\Models\User;
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$user = User::where('email','ahmed@gmail.com')->first();
if(!$user){ echo "no user\n"; exit(1);} 
echo "User {$user->id} {$user->email}\n";
$q = ContactMessage::query()->where(function($qq) use($user){
    $qq->where('user_id',$user->id)->orWhere(function($qq2) use($user){
        $qq2->whereNull('user_id')->where('email',$user->email);
    });
});
echo 'Count=' . $q->count() . "\n";
foreach($q->orderByDesc('created_at')->get(['id','user_id','email','subject'])->all() as $m){
    echo "- {$m->id} user_id=".($m->user_id??'null')." email={$m->email} subject={$m->subject}\n";
}
