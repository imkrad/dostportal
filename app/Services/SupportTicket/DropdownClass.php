<?php

namespace App\Services\SupportTicket;

use App\Models\ListSystem;

class DropdownClass
{   
    public function systems(){
        $data = ListSystem::get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
            ];
        });
        return $data;
    }
}
