<?php

namespace App\Repositories;

use App\Models\Resident;

class ResidentRepository
{
    public function findByDocument($document)
    {
        return Resident::where('document', $document)->where('status', 'active')->first();
    }

    public function createResident(array $data)
    {
        return Resident::create($data);
    }
}
