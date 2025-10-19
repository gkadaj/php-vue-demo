<?php
declare(strict_types=1);

namespace Domain\Service;

use Domain\Entity\Vehicle;
use Domain\Repository\VehicleRepositoryInterface;

class VehiclesReader
{
    public function __construct(private readonly VehicleRepositoryInterface $vehicleRepository)
    {
    }

    public function getVehicleById(int $id): Vehicle
    {
        return $this->vehicleRepository->getById($id);
    }
}
