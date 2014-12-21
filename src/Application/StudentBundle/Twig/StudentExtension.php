<?php

namespace Application\StudentBundle\Twig;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Tag;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Ferus\FairPayApi\Exception\ApiErrorException;
use Ferus\FairPayApi\FairPay;

/**
 * @Service
 * @Tag("twig.extension")
 */
class StudentExtension extends \Twig_Extension 
{
	protected $use_proxy;

    /**
     * @InjectParams({
     *     "use_proxy" = @Inject("%use_proxy%")
     * })
     */
    function __construct($use_proxy)
    {
        $this->use_proxy = (boolean) $use_proxy;
    }

    public function getFunctions()
    {
        return array(
            'isContributor' => new \Twig_Function_Method($this, 'isContributor'),
        );
    }

    public function isContributor($id)
    {
        try{
            $fairpay = new FairPay();
            if ($this->use_proxy) {
	            $fairpay->setCurlParam(CURLOPT_HTTPPROXYTUNNEL, true);
	            $fairpay->setCurlParam(CURLOPT_PROXY, "proxy.esiee.fr:3128");
            }
            $student = $fairpay->getStudent($id);
        }
        catch(ApiErrorException $e){
            return false;
        }
        return $student->is_contributor;
    }

	public function getName()
	{
		return 'student_extension';
	}
}
