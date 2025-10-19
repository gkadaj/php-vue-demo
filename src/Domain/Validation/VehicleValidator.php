<?php
declare(strict_types=1);

namespace Domain\Validation;

use Domain\Service\VehicleDTO;

class VehicleValidator
{
    public function validate(VehicleDTO $vehicleDTO): bool
    {
        if (empty($vehicleDTO->registrationNumber)) {
            throw new \InvalidArgumentException('Registration number is required');
        }
        if (empty($vehicleDTO->brand)) {
            throw new \InvalidArgumentException('Brand is required');
        }
        if (empty($vehicleDTO->model)) {
            throw new \InvalidArgumentException('Model is required');
        }
        if (empty($vehicleDTO->type)) {
            throw new \InvalidArgumentException('Type is required');
        }

        return true;
    }
}
