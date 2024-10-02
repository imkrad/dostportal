<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'responsibility_center_code',
    ];

    public function division()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'division_id');
    }

    
}
