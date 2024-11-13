<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    use HasFactory;

    // Define fillable fields to allow mass assignment
    protected $fillable = [
        'name',
        'country_code',
        'mobile',
        'email',
        'gender'
    ];
}
