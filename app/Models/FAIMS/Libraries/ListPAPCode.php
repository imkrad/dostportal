<?php

namespace App\Models\FAIMS\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPAPCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'code',
        'allocated_budget',
    ];
}
