<?php
namespace App\Controller;

use App\Entity\Discount;
use App\Repository\DiscountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @var DiscountRepository
     */
    private $discountRepository;

    public function __construct(DiscountRepository $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    }
    /**
     * @Route("/")
     */
    public function index()
    {
        $discounts = $this->discountRepository->findAll();
        return $this->render('default/index.html.twig', [
           'vouchers' => $discounts,
        ]);
    }

    /**
     * reset database and load fixtures for API demo
     */
    public function resetData()
    {
        //functionality to reset database and load fixtures will be here
    }
}