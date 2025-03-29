<?php

namespace App\Repositories;

use App\Models\Area;

class AreaRepository
{
    public function getAvailableAreas()
    {
        return Area::where('status', 'active')->get();
    }
}
