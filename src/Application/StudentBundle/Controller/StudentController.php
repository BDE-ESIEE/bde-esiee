<?php

namespace Application\StudentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ferus\FairPayApi\Exception\ApiErrorException;
use Ferus\FairPayApi\FairPay;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    public function searchAction($query)
    {
        try{
            $fairpay = new FairPay();
            if ((boolean) $this->container->getParameter('use_proxy')) {
	            $fairpay->setCurlParam(CURLOPT_HTTPPROXYTUNNEL, true);
	            $fairpay->setCurlParam(CURLOPT_PROXY, "proxy.esiee.fr:3128");
            }
            $student = $fairpay->getStudent($query);
        }
        catch(ApiErrorException $e){
            return new Response(json_encode($e->returned_value), $e->returned_value->code);
        }
        return new Response(json_encode($student), 200);
    }
}
