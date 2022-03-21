<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'checked',
        'timecheck'
    ];

    protected $table = 'mail_checks';
}
