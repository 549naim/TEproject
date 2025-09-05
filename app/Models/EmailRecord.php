<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailRecord extends Model
{
    protected $fillable = [
        'year',
        'department_id',
        'batch_id',
        'email_subject',
    ];
}
