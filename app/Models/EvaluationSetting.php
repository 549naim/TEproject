<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationSetting extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
    ];
}
