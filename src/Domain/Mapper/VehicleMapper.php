<?php
declare(strict_types=1);

namespace Domain\Mapper;

use Domain\Entity\Vehicle;
use Domain\Service\VehicleDTO;

class VehicleMapper
{
    public function dtoToEntity(VehicleDTO $vehicleDTO): Vehicle
    {
        return (new Vehicle())
            ->setId($vehicleDTO->id)
            ->setRegistrationNumber($vehicleDTO->registrationNumber)
            ->setBrand($vehicleDTO->brand)
            ->setModel($vehicleDTO->model)
            ->setType($vehicleDTO->type);
    }
    
    public function entityToDto(Vehicle $vehicle): VehicleDTO
    {
        $vehicleDTO = new VehicleDTO();
        $vehicleDTO->id = $vehicle->getId();
        $vehicleDTO->registrationNumber = $vehicle->getRegistrationNumber();
        $vehicleDTO->brand = $vehicle->getBrand();
        $vehicleDTO->model = $vehicle->getModel();
        $vehicleDTO->type = $vehicle->getType();
        $vehicleDTO->createdAt = date('Y-m-d H:i', $vehicle->getCreatedAt());
        $vehicleDTO->updatedAt = date('Y-m-d H:i', $vehicle->getUpdatedAt());

        return $vehicleDTO;
    }
}