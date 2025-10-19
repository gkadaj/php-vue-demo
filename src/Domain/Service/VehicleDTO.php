<?php
declare(strict_types=1);

namespace Domain\Service;

class VehicleDTO
{
    public int $id;
    public string $registrationNumber;
    public string $brand;
    public string $model;
    public string $type;
    public string $createdAt;
    public string $updatedAt;
}
