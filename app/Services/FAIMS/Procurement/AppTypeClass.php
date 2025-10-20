<?php

namespace App\Services\FAIMS\Procurement;

use App\Models\FAIMS\Procurement\Libraries\AppType;
use App\Http\Resources\FAIMS\Procurement\AppTypeResource;
use Illuminate\Support\Facades\Auth;

class AppTypeClass
{
    public function lists($request){
        $data = AppTypeResource::collection(
            AppType::query()
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('title', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );

        return $data;
    }
    

   
}
