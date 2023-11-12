<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Backtrace\Arguments\ReducedArgument\TruncatedReducedArgument;

use function PHPUnit\Framework\callback;

class Settings extends Model
{
    use HasFactory;

    private $error = [
        "id_settings not found"
    ];

    public function settings() {

        $access = DB::table("settings")->where("id_settings", 1)->first();

        if ( !$access ) {
            return false;
        }

        return $access;

    }

}