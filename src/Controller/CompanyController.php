<?php

namespace App\Controller;

use App\Manager\PRHCompanyParser;
use App\Manager\PRHInterfaceManager;
use App\Util\StringValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class CompanyController
{
    /**
     * Fetch company information using business id
     * @param string $id
     * @return JsonResponse
     */
    public function index(string $id): JsonResponse
    {
        try {
            // Validate route parameters
            if (!StringValidator::isValidBusinessId($id)) {
                return new JsonResponse('Invalid business id.', 400);
            }

            //Fetch data
            $manager = new PRHInterfaceManager();
            $results = $manager->getCompanyByBusinessID($id);

            // Return 404 if no results
            if (count($results) === 0) {
                return new JsonResponse('Not found.', 404);
            }

            // Use only first result
            $data = $results[0];

            // Parse and return data
            $parser = new PRHCompanyParser($data);

            return new JsonResponse([
                'name' => $parser->getName(),
                'website' => $parser->getWebsiteAddress(),
                'address' => $parser->getLatestAddress(),
                'business_line' => $parser->getBusinessLine()
            ]);
        } catch (Throwable $e) {
            // TODO: Log error
            return new JsonResponse('Internal error.', 500);
        }
    }
}