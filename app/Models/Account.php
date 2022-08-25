<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'account';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userId',
        'userName',
        'email',
        'firstName',
        'lastName',
        'gender',
        'phone',
        'accessLevel',
        'validateEmail',
        'requestIp',
        'requestIpCountry',
        'requestIpCountryCode',
    ];

    /**
     * Get the Account Details.
     */
    public function details()
    {
        return $this->hasMany(Details::class);
    }

    /**
     * Get the Account ApiLogs.
     */
    public function apilogs()
    {
        return $this->hasMany(ApiLogs::class);
    }
}
