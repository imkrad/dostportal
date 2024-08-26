<?php

namespace App\Services\Hr;

use App\Models\ListData;
use App\Models\ListSalary;

class RateClass
{
    public function salaries(){
        $data = ListSalary::all()->map(function ($item) {
            return [
                'value' => $item->id,
                'grade' => $item->grade,
                'amount' => $item->amount
            ];
        });
        return $data;
    }

    public function special(){
        $data = ListData::where('type','Special Order')->map(function ($item) {
            return [
                'value' => $item->id,
                'grade' => $item->name,
            ];
        });
        return $data;
    }

    public function administrative(){
        $data = ListData::where('type','Administrative Order')->map(function ($item) {
            return [
                'value' => $item->id,
                'grade' => $item->name,
            ];
        });
        return $data;
    }
}
