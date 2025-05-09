<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'password',
        'address',
        'status',
    ];

    protected $hidden = [
        'password',
    ];
}
