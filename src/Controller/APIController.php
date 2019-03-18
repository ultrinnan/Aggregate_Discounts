<?php
namespace App\Controller;

use App\API\VouchersAPI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    /**
     * @Route("/api/")
     */
    public function index()
    {
        $api = new VouchersAPI();

        $vouchers = $api->getDiscounts();

        return $this->render('default/index.html.twig', [
           'data' => $vouchers,
        ]);
    }
}