<?php

namespace Application\AurionBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description="Retrieves the list of events",
     *  resource=true,
     *  output={"class"="Application\BDEBundle\Entity\Event"},
     *  statusCodes={
     *      200="Returned when successful"
     *  }
     * )
     * @Rest\View(statusCode=200)
     */
     private function dateToCal($date)
   	 {
   		 $dateTime = new \DateTime($date);
   		 return $dateTime->format('Ymd\THis');
   	  }

     private function escapeString($string) {
       return preg_replace('/([\,;])/','\\\$1', $string);
     }

     public function decode($data)
     {
         $ics = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//Cours ESIEE Paris//FR\r\nX-WR-CALNAME:Mes cours ESIEE\r\nX-WR-TIMEZONE:Europe/Paris\r\nCALSCALE:GREGORIAN\r\n";

       foreach ($data as $event) {
         $ics .= "BEGIN:VEVENT\r\nUID:".$event['id']."\r\nLOCATION:".$this->escapeString($event['place'])."\r\nSUMMARY:".$this->escapeString($event['name'])."\r\nDESCRIPTION:".$this->escapeString($event['prof'])."\r\nDTSTART:".$this->dateToCal($event['start'])."\r\nDTEND:".$this->dateToCal($event['end'])."\r\nEND:VEVENT\r\n";
       }

       $ics .= "END:VCALENDAR";

       return $ics;
     }

    public function indexAction($_format)
    {
        $event_json = array();
        $view = $this->view($event_json, 200)
            ->setTemplate("ApplicationAurionBundle:Aurion:agenda.html.twig")
            ->setTemplateVar('events')
        ;

        return $this->handleView($view);
    }

    public function getDataAction(){
      $url = "http://ade.wallforfry.fr/api/ade-esiee/calendar";

      $data = array("username" => $_POST["login"], "password" => $_POST["password"], "day" => "", "month" => "");

      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_POST, 1);
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

        $event_id = 0;

        foreach ($event_list as $event) {
          if (preg_match("/TD/", $event["name"])) {
            $color = "#f39c12";
          }
          elseif (preg_match("/CTRL/", $event["name"])){
            $color = "#e74c3c";
          }
          elseif (preg_match("/PERS/", $event["name"])){
            $color = "#95a5a6";
          }
          elseif (preg_match("/TP/", $event["name"])){
            $color = "#27ae60";
          }
          else {
            $color = "#35a9fb";
          }

          $event_json[] = array(
                  'id'        => $event_id,
                  'title'     => $event["name"]."\n".$event["rooms"]."\n".$event["prof"],
                  'name'      => $event["name"],
                  'start'     => date("Y-m-d H:i:s", strtotime($event["start"])),
                  'end'       => date("Y-m-d H:i:s", strtotime($event["end"])),
                  'allDay'    => false,
                  'color'     => $color,//$event->getCategory()->getBackgroundColor(),
                  'textColor' => "white",//$event->getCategory()->getTextColor(),
                  'place'     => $event["rooms"],
                  'prof'      => $event["prof"],
                  'club_id'   => null,
                  'news_ids'  => 0,
          );
          $event_id = $event_id + 1;
        }



          $ics_file = $this->decode($event_json);
          file_put_contents("agenda/".$_POST["login"].".ics", $ics_file, LOCK_EX);

          $response = new Response(json_encode($event_json));
          $response->headers->set('Content-Type', 'application/json');
          return $response;
      }
    }
}
