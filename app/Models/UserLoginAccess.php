<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Password;


class UserLoginAccess extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

 /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | STATIC FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function generateToken()
    {
        return self::create([
            'access_token' => Password::getRepository()->createNewToken(),
            'refresh_token' => Password::getRepository()->createNewToken(),
            'user_id' => auth()->user()->id,
            'expired_at' => self::getNow()->addMinutes(10),
            'refresh_token_expired_at' => self::getNow()->addMinutes(100),
        ]);
    }

    public static function getNow()
    {
        $carbon = Carbon::now()->setTimezone(config('app.timezone'));
        return $carbon;
    }

    public static function addMinute($num)
    {
        return self::getNow()->addMinutes($num)->toDateTimeString();
    }



}
