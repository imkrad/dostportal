<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','short','unit_id'
    ];

    public function main()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'unit_id', 'id');
    }
}
