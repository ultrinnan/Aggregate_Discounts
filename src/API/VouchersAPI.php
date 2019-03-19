<?php

namespace App\API;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VouchersAPI
{
    /**
     * This method will return all vouchers from our partner
     * in a JSON format
     * @return string JSON formatted string
     */
    public function getDiscounts()
    {
        if ($this->checkFirstVisit()){
            return $this->getMockedData('input1.json');
        } else {
            return $this->getMockedData('input2.json');
        }
    }

    /**
     * check if this is first request of dataFixtures
     * @return bool
     */
    public function checkFirstVisit()
    {
        $request = Request::createFromGlobals();
        if (!$request->cookies->get('checked')) {
            $response = new Response();
            $cookie = new Cookie('checked', true, strtotime('now + 5 minutes'));
            $response->headers->setCookie($cookie);
            $response->send();
            return true;
        } else {
            return false;
        }
    }

    public function getMockedData($file)
    {
        $data_file = dirname(__DIR__) . '/../src/API/data/' . $file;
        try{
            $data = file_get_contents($data_file);
        } catch (\ErrorException $errorException){
            return 'Requested file ('. $data_file . ') not found';
        }
        return json_decode($data, true);
    }
}