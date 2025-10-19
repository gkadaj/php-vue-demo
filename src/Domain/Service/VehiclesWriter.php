<?php
declare(strict_types=1);

namespace Domain\Service;

use Domain\Mapper\VehicleMapper;
use Domain\Repository\VehicleRepositoryInterface;

class VehiclesWriter
{
    public function __construct(private readonly VehicleRepositoryInterface $vehicleRepository)
    {
    }

    public function saveVehicle(VehicleDTO $vehicleDTO): void
    {
        $vehicle = (new VehicleMapper())->dtoToEntity($vehicleDTO);
        $this->vehicleRepository->persist($vehicle);
    }

    public function deleteById(int $id): void
    {
        $this->vehicleRepository->deleteById($id);
    }
}
