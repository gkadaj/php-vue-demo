<?php
declare(strict_types=1);

namespace App\Controller;

use Domain\Mapper\VehicleMapper;
use Domain\Sanitization\VehicleSanitizer;
use Domain\Service\VehicleDTO;
use Domain\Service\VehiclesBuilder;
use Domain\Service\VehiclesReader;
use Domain\Service\VehiclesWriter;
use Domain\Validation\VehicleValidator;
use Persistence\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};

class VehicleController extends BaseController
{
    public function index(): Response
    {
        ob_start();
        include __DIR__ . '/../views/index.php';
        return (new Response(ob_get_clean()))->send();
    }

    public function list(): JsonResponse
    {
        $results = (new VehiclesBuilder(new VehicleRepository()))->getList();

        return $this->toJsonResponse(['results' => $results]);
    }

    public function save(int $id, Request $request): JsonResponse
    {
        $vehicleData = json_decode($request->getContent());

        $vehicleDTO = new VehicleDTO();
        $vehicleDTO->id = $id;
        $vehicleDTO->registrationNumber = $vehicleData->registrationNumber;
        $vehicleDTO->brand = $vehicleData->brand;
        $vehicleDTO->model = $vehicleData->model;
        $vehicleDTO->type = $vehicleData->type;

        $vehicleDTO = (new VehicleSanitizer())->sanitize($vehicleDTO);
        (new VehicleValidator())->validate($vehicleDTO);

        $vehicleRepository = new VehicleRepository();
        $vehicleMapper = new VehicleMapper();
        (new VehiclesWriter($vehicleRepository))->saveVehicle($vehicleDTO);
        $updatedVehicleEntity = (new VehiclesReader($vehicleRepository))->getVehicleById($id);
        $updatedVehicleDto = $vehicleMapper->entityToDto($updatedVehicleEntity);

        return $this->toJsonResponse([$id, json_encode($updatedVehicleDto)]);
    }

    public function delete(int $id): JsonResponse
    {
        (new VehiclesWriter(new VehicleRepository()))->deleteById($id);

        return $this->toJsonResponse([$id]);
    }
}
