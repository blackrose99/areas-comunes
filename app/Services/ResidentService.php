<?php

namespace App\Services;

use App\Repositories\ResidentRepository;

class ResidentService
{
    protected $residentRepository;

    public function __construct(ResidentRepository $residentRepository)
    {
        $this->residentRepository = $residentRepository;
    }

    public function findOrCreateResident($document, $data)
    {
        $resident = $this->residentRepository->findByDocument($document);
        if (!$resident) {
            $resident = $this->residentRepository->createResident($data);
        }
        return $resident;
    }
}
