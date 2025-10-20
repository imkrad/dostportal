<?php

namespace App\Models\FAIMS\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeOfProcurement extends Model
{
    use HasFactory;
    protected $fillable = [
        'mode',
    ];
    
}

