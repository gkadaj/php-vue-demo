<?php
declare(strict_types=1);

namespace Domain\Sanitization;

use Domain\Service\VehicleDTO;

class VehicleSanitizer
{
    public function sanitize(VehicleDTO $vehicleDTO): VehicleDTO
    {
        $vehicleDTO->registrationNumber = $this->sanitizeRegistrationNumber($vehicleDTO->registrationNumber);
        $vehicleDTO->brand = $this->sanitizeInput($vehicleDTO->brand);
        $vehicleDTO->model = $this->sanitizeInput($vehicleDTO->model);
        $vehicleDTO->type = $this->sanitizeInput($vehicleDTO->type);

        return $vehicleDTO;
    }

    private function sanitizeRegistrationNumber(string $registrationNumber): string
    {
        $sanitized = preg_replace('/[^A-Za-z0-9]/', '', $this->sanitizeInput($registrationNumber));

        return strtoupper($sanitized);
    }

    private function sanitizeInput(string $input): string
    {
        $sanitized = strip_tags($input);
        $sanitized = htmlspecialchars($sanitized, ENT_QUOTES, 'UTF-8');

        return trim($sanitized);
    }
}