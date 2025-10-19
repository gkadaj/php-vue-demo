<?php
declare(strict_types=1);

namespace Domain\Repository;

use Domain\Entity\Vehicle;

interface VehicleRepositoryInterface
{
    public function getList(): array;

    public function getById(int $id): Vehicle;

    public function deleteById(int $id): void;

    public function persist(Vehicle $vehicle): void;
}
