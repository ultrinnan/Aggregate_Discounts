<?php

namespace App\DataFixtures;

use App\Entity\Discount;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
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

            $manager->persist($discount);
        }

        $manager->flush();
    }
}