<?php

namespace Application\PoudlardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Application\PoudlardBundle\Entity\ClubHasPoints;
use Application\PoudlardBundle\Entity\Points;
use Symfony\Component\HttpFoundation\Response;

class HouseController extends Controller
{
    /**
     * @Template
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();

		$house_list  = $em->getRepository('ApplicationPoudlardBundle:House')->findAll();
		$points_list = $em->getRepository('ApplicationPoudlardBundle:Points')->findBy(array(), array('date' => 'desc'));
		$finalScore  = array();
        $max = 0;

        foreach ($house_list as $house) {
        	$finalScore[$house->getId()] = array(
				'house'   => $house,
                'score'   => $house->getScore(),
				'history' => array(),
        	);
            if ($house->getScore() > $max)
                $max = $house->getScore();
        }

        $max = max($max + 30, 200);
        foreach ($finalScore as $key => $value) {
            $finalScore[$key]['percent'] = round($finalScore[$key]['score'] / $max * 100);
        }

        foreach ($points_list as $point) {
        	$totalByHouse = $point->getTotalByHouse();
        	foreach ($totalByHouse as $house => $value) {
        		$finalScore[$house]['history'][] = array($value[0], $point);
        	}
        }

        return array(
        	'finalScore' => $finalScore,
        );    
    }

    public function createPointsAction()
    {
    	$em = $this->getDoctrine()->getManager();

		$club_list  = $em->getRepository('ApplicationBDEBundle:Club')->findAll();

		$points = new Points();
		$points->setDate(new \DateTime());
		$points->setName('Présence SDC');
		foreach ($club_list as $club) {
			if (!in_array($club->getId(), array(10, 14, 9, 5)))
			{
				$clubHasPoints = new ClubHasPoints();
				$clubHasPoints->setAmount(2);
                $clubHasPoints->setBonusMalus(0);
                $clubHasPoints->setClub($club);

                $em->persist($clubHasPoints);
                $points->addDistribution($clubHasPoints);
			}
		}
        $em->persist($points);
        // $em->flush();

        return new Response('<html><body></body></html>');
    }
}
