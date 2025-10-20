<?php
declare(strict_types=1);

namespace Persistence\Repository;

use App\SQLiteConnection;
use Domain\Entity\Vehicle;
use Domain\Mapper\VehicleMapper;
use Domain\Repository\VehicleRepositoryInterface;
use Domain\Service\VehicleDTO;
use Exception;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class VehicleRepository implements VehicleRepositoryInterface
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new SQLiteConnection())->connect();
    }

    public function getList(): array
    {
        $results = $this->pdo->query('SELECT * FROM vehicles');

        $items = [];
        foreach ($results as $row) {
            $items[] = $this->rowToEntity($row);
        }

        return $items;
    }

    /**
     * @throws Exception
     */
    public function getById(int $id): Vehicle
    {
        $sql = "SELECT * FROM vehicles WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            throw new ResourceNotFoundException('Vehicle not found');
        }

        return $this->rowToEntity($row);
    }

    public function deleteById(int $id): void
    {
        $sql = "DELETE FROM vehicles WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }

    public function persist(Vehicle $vehicle): void
    {
        $sql = "UPDATE vehicles SET registration_number = ?, brand = ?, model = ?, type = ?, updated_at = ? WHERE id = ?";

        $this->pdo->prepare($sql)
            ->execute([
                $vehicle->getRegistrationNumber(),
                $vehicle->getBrand(),
                $vehicle->getModel(),
                $vehicle->getType(),
                time(),
                $vehicle->getId()]);
    }

    private function rowToEntity($row)
    {
        return (new Vehicle())
            ->setId($row['id'])
            ->setRegistrationNumber($row['registration_number'])
            ->setBrand($row['brand'])
            ->setModel($row['model'])
            ->setType($row['type'])
            ->setCreatedAt($row['created_at'])
            ->setUpdatedAt($row['updated_at'])
        ;
    }
}
