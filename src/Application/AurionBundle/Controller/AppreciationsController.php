<?php

namespace Application\AurionBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Response;

class AppreciationsController extends FOSRestController
{
    public function indexAction($_format){
      $event_json = array();
      $view = $this->view($event_json, 200)
          ->setTemplate("ApplicationAurionBundle:Aurion:appreciations.html.twig")
          ->setTemplateVar('events')
      ;

      return $this->handleView($view);
    }

    public function getDataAction(){
      $url = "http://localhost:5000/api/ade-esiee/appreciations";

      $data = array("username" => $_POST["login"], "password" => $_POST["password"]);

      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
      curl_setopt($ch, CURLOPT_PROXY, 'proxy.esiee.fr:3128');
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($ch);
      curl_close($ch);


      $event_list = json_decode($response, true);
      $event_json = array();

      if(!empty($event_list[0]["error"])){
        $response = new Response(json_encode("1"));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
      }
      else {
          $response = new Response(json_encode($event_list));
          $response->headers->set('Content-Type', 'application/json');
          return $response;
      }
    }
}
