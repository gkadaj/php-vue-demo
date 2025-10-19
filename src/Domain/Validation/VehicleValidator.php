<?php
declare(strict_types=1);

namespace Domain\Validation;

use Domain\Service\VehicleDTO;

class VehicleValidator
{
    public function validate(VehicleDTO $vehicleDTO): bool
    {
        if (empty($vehicleDTO->registrationNumber) || strlen($vehicleDTO->registrationNumber) > 16) {
            throw new \InvalidArgumentException('Registration number is required and must be less or equal than 16 characters');
        }
        if (empty($vehicleDTO->brand) || strlen($vehicleDTO->brand) > 60) {
            throw new \InvalidArgumentException('Brand is required and must be less or equal than 60 characters');
        }
        if (empty($vehicleDTO->model) || strlen($vehicleDTO->model) > 60) {
            throw new \InvalidArgumentException('Model is required and must be less or equal than 60 characters');
        }
        if (empty($vehicleDTO->type)) {
            throw new \InvalidArgumentException('Type is required');
        }

        return true;
    }
}
