<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Userlist extends Model
{
    use HasFactory;
    use HasUuids;


    protected $casts = [
        "title" => "encrypted",
        "login" => "encrypted",
        "password" => "encrypted",
        "description" => "encrypted"
    ];

    protected $fillable = [
        "title",
        "login",
        "password",
        "description",
        "user_id"
    ];

////    public static function boot(): void
////    {
////        parent::boot();
////
////        self::updating(function($model){
////
////            dd($model);
//////            if (!($changed = $userlist->getDirty())) {
//////                return true;
//////            }
//////
//////            dd($changed);
//////
//////            if (!empty($changed['title'])) {
//////                $userlist->title = Crypt::encrypt($userlist->title, false);
//////            }
//////            if (!empty($changed['login'])) {
//////                $userlist->login = Crypt::encrypt($userlist->login, false);
//////            }
//////            if (!empty($changed['password'])) {
//////                $userlist->password = Crypt::encrypt($userlist->password, false);
//////            }
//////            if (!empty($changed['description'])) {
//////                $userlist->description = Crypt::encrypt($userlist->description, false);
//////            }
//////            $userlist->save(false);
//////            return true;
////        });
//    }
}
