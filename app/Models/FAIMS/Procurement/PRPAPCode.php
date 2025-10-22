<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PRPAPCode extends Model
{
    use HasFactory;
    protected $table = 'pr_pap_codes';
    protected $fillable = [
        'purchase_request_id',
        'list_pap_code_id',   
        
    ];

    public function purchase_request()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\PurchaseRequest', 'purchase_request_id');
    }

    public function pap_code()
    {
        return $this->belongsTo('App\Models\FAIMS\Libraries\ListPAPCode', 'list_pap_code_id');
    }


}
