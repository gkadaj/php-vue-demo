<?php
declare(strict_types=1);

namespace Domain\Service;

use Domain\Entity\Vehicle;
use Domain\Mapper\VehicleMapper;
use Domain\Repository\VehicleRepositoryInterface;

class VehiclesBuilder
{
    public function __construct(private readonly VehicleRepositoryInterface $vehicleRepository)
    {
    }

    public function getList(): array
    {
        $items = $this->vehicleRepository->getList();

        return array_map([$this, 'entityToDTO'], $items);
    }

    private function entityToDTO(Vehicle $vehicle): VehicleDTO
    {
        return (new VehicleMapper())->entityToDto($vehicle);
    }
}
