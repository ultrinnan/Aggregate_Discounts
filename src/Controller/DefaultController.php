<?php
namespace App\Controller;

use App\DataFixtures\AppFixtures;
use App\Entity\Discount;
use App\Repository\DiscountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
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
        $discounts = $this->discountRepository->findUnsubmitted();
        return $this->render('default/index.html.twig', [
           'vouchers' => $discounts,
        ]);
    }

    /**
     * @Route("/submit_discount")
     * @param Request $request
     * @return JsonResponse|bool
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function submitDiscount(Request $request)
    {
        if($request->request->get('id')){
            $id = (int)$request->request->get('id');
            $discount = $this->discountRepository->findById($id);
            if ($discount){
                $discount->setSubmitted(true);
                $this->discountRepository->update($discount);
                return new JsonResponse(array(
                    'status' => 'Success',
                    'message' => 'Submitted'),
                    200);
            }
        } else {
            return new JsonResponse(array(
                'status' => 'Error',
                'message' => 'Error'),
                400);
        }
    }

    /**
     * @Route("/reset_base")
     * @param Request $request
     * @param KernelInterface $kernel
     * @return JsonResponse
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function resetData(Request $request, KernelInterface $kernel)
    {
        if($request->request->get('reset_base')){
            $discounts = $this->discountRepository->findAll();
            if ($discounts) {
                foreach ($discounts as $discount) {
                    $this->discountRepository->delete($this->discountRepository->getId($discount));
                }
            }

            // create 9 discounts
            for ($i = 1; $i < 10; $i++) {
                $discount = new Discount();

                $discount->setShop('Test shop ' . $i);
                $discount->setCode('TESTCODE' . $i);
                $discount->setProgramId('12345' . $i);
                $discount->setValue('Some description for discount ' . $i);
                $discount->setUrl('https://fedirko.pro');
                $discount->setDiscount('7% for all');
                $discount->setCurrency('UAH');
                $discount->setCommissionValueFormatted('Default');
                $discount->setValidFromDate(new \DateTime("now - 7 days"));
                $discount->setExpireDate(new \DateTime("now + 7 days"));
                $discount->setSubmitted(false);
                $discount->setSubmitted(false);

                $this->discountRepository->create($discount);
            }

            return new JsonResponse(array(
                'status' => 'Success',
                'message' => 'Reset database.',
                200)
            );
        }
        return new JsonResponse(array(
            'status' => 'Error',
            'message' => 'Error'),
            400);
    }
}