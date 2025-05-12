<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verify extends Model
{
    use HasFactory;
    protected $table = 'tbl_verify';

    protected $fillable = [
        'email',
        'otp'
    ];
}
