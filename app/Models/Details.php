<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Details extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'accountType',
        'companyName',
        'vatNumber',
        'cocNumber',
        'firstName',
        'lastName',
        'address',
        'streetNumber',
        'zipCode',
        'city',
        'countryCode',
        'emailAddress',
        'unconfirmedEmail',
        'emailAddressValidated',
        'phoneNumber',
        'phoneNumberMobile',
        'language',
        'emailAddressAbuse',
        'newsletter',
        'agreeToc',
        'agreeAup',
        'agreeDpa',
        'isAllowedFlexMetal',
    ];
}
