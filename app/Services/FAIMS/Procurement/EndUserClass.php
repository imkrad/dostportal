<?php

namespace App\Services\FAIMS\Procurement;

use App\Models\FAIMS\Procurement\Libraries\EndUser;
use App\Http\Resources\FAIMS\Procurement\EndUserResource;
use Illuminate\Support\Facades\Auth;

class EndUserClass
{
    public function lists($request){
        $data = EndUserResource::collection(
            EndUser::query()
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('title', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );

        return $data;
    }
    

   
}
