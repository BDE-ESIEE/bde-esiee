<?php

namespace Application\BDEBundle\Twig\DataURI;

use Application\BDEBundle\Twig\DataURI\Data;

class Dumper
{

    /**
     * Transform a DataURI\Data object to its URI representation and take
     * the following form :
     *
     * data:[<mediatype>][;base64],<data>
     *
     * @param Data $dataURI
     * @return string
     */
    public static function dump(Data $dataURI)
    {
        $parameters = '';

        if (0 !== count($params = $dataURI->getParameters())) {
            foreach ($params as $paramName => $paramValue) {
                $parameters .= sprintf(';%s=%s', $paramName, $paramValue);
            }
        }

        $base64 = '';

        if($dataURI->isBinaryData()){
            $base64 = sprintf(';%s', Data::BASE_64);
            $data = base64_encode($dataURI->getData());
        }else{
            $data = rawurlencode($dataURI->getData());
        }

        return sprintf('data:%s%s%s,%s'
                , $dataURI->getMimeType()
                , $parameters
                , $base64
                , $data
        );
    }
}
