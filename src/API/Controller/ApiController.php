<?php
namespace App\API\Controller;

use App\API\VouchersAPI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiController extends AbstractController
{
    /**
     * @Rest\Get("/api")
     */
    public function index()
    {
        $api = new VouchersAPI();

        $vouchers = $api->getDiscounts();

        return $this->json($vouchers);
    }
}