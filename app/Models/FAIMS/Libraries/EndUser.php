<?php

namespace App\Models\FAIMS\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
    ];

    public function end_user()
    {
        return $this->belongsTo('App\Models\FAIMS\Libraries\EndUser');
    }


}
