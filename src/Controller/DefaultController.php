<?php
namespace App\Controller;

use App\API\VouchersAPI;
use App\Entity\Discount;
use App\Repository\DiscountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $count = count($discounts);
        return $this->render('default/index.html.twig', [
           'vouchers' => $discounts,
            'count' => $count,
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
     * @return JsonResponse
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function resetData(Request $request)
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

    /**
     * @Route("/check_api")
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function checkApi(Request $request)
    {
        if($request->request->get('check_api')){

            $old_discounts = $this->discountRepository->findAll();

            //todo: this will work with the real api endpoint. Maybe later)
//            $url = "http://separate.test/api";
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch, CURLOPT_URL, $url);
//            $result = curl_exec($ch);
//            curl_close($ch);

            $pseudoApi = new VouchersAPI();
            $new_discounts = $pseudoApi->getDiscounts();

            foreach ($new_discounts as $new){
                $found = false;
                foreach ($old_discounts as $old){
                    if ($new['programId'] == $old->getProgramId()){
                        $found = true;
                        if (
                            $old->getShop() !== $new['program_name'] ||
                            $old->getCode() !== $new['code'] ||
                            $old->getValidFromDate() !== $new['startDate'] ||
                            $old->getExpireDate() !== $new['expiryDate'] ||
                            $old->getValue() !== $new['program_name'] ||
                            $old->getUrl() !== $new['destinationUrl'] ||
                            $old->getDiscount() !== $new['discount'] ||
                            $old->getCurrency() !== $new['currency'] ||
                            $old->getCommissionValueFormatted() !== $new['commissionValueFormatted']
                        ){
                            $old->setShop($new['program_name']);
                            $old->setCode($new['code']);
                            $old->setValidFromDate(new \DateTime($new['startDate']));
                            $old->setExpireDate(new \DateTime($new['expiryDate']));
                            $old->setValue($new['program_name']);
                            $old->setUrl($new['destinationUrl']);
                            $old->setDiscount($new['discount']);
                            $old->setCurrency($new['currency']);
                            $old->setCommissionValueFormatted($new['commissionValueFormatted']);
                            $old->setSubmitted(false);

                            $this->discountRepository->update($old);
                        }
                    }
                }
                if (!$found){
                    $discount = new Discount();

                    $discount->setShop($new['program_name']);
                    $discount->setProgramId($new['programId']);
                    $discount->setCode($new['code']);
                    $discount->setValidFromDate(new \DateTime($new['startDate']));
                    $discount->setExpireDate(new \DateTime($new['expiryDate']));
                    $discount->setValue($new['program_name']);
                    $discount->setUrl($new['destinationUrl']);
                    $discount->setDiscount($new['discount']);
                    $discount->setCurrency($new['currency']);
                    $discount->setCommissionValueFormatted($new['commissionValueFormatted']);
                    $discount->setSubmitted(false);

                    $this->discountRepository->create($discount);
                }
            }

            return new JsonResponse(array(
                'status' => 'Success',
                'message' => 'Updated from API.',
                200)
            );
        }
        return new JsonResponse(array(
            'status' => 'Error',
            'message' => 'Error'),
            400);
    }
}