<?php

namespace Application\BDEBundle\Handler;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Util\Codes;

use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;

use Application\BDEBundle\Decoder\ICSDecoder;

class ICSHandler
{
	private $decoder;

	public function __construct(ICSDecoder $decoder)
    {
        $this->decoder = $decoder;
    }

    /**
     * Converts the viewdata to a ICS feed.
     * @return Response
     */
    public function createResponse(ViewHandler $handler, View $view, Request $request)
    {
        $content = $this->decoder->decode($view->getData());
        $code = Codes::HTTP_OK;

        return new Response($content, $code, $view->getHeaders());
    }
}