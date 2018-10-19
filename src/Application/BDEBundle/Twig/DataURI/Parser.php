<?php

namespace Application\BDEBundle\Twig\DataURI;

use Application\BDEBundle\Twig\DataURI\Exception\InvalidDataException;
use Application\BDEBundle\Twig\DataURI\Exception\InvalidArgumentException;
use Application\BDEBundle\Twig\DataURI\Data;

class Parser
{
    /**
     * DATA URI SCHEME REGEXP
     * offset #1 MimeType
     * offset #2 Parameters
     * offset #3 Datas
     */
    const DATA_URI_REGEXP = '/data:([a-zA-Z-\/+]*)([a-zA-Z0-9-_;=.+]+)?,(.*)/';

    /**
     * Parse a data URI and return a DataUri\Data
     *
     * @param string $dataUri A data URI
     * @param int $len
     * @param bool $strict
     * @return Data
     * @throws InvalidDataException
     * @throws InvalidArgumentException
     */
    public static function parse($dataUri, $len = Data::TAGLEN, $strict = false)
    {
        $dataParams = $matches = array();

        if ( ! preg_match(self::DATA_URI_REGEXP, $dataUri, $matches)) {
            throw new InvalidArgumentException('Could not parse the URL scheme');
        }

        $base64 = false;

        $mimeType = $matches[1] ? $matches[1] : null;
        $params = $matches[2];
        $rawData = $matches[3];

        if ("" !== $params) {
            foreach (explode(';', $params) as $param) {
                if (strstr($param, '=')) {
                    $param = explode('=', $param);
                    $dataParams[array_shift($param)] = array_pop($param);
                } elseif ($param === Data::BASE_64) {
                    $base64 = true;
                }
            }
        }

        if (($base64 && ! $rawData = base64_decode($rawData, $strict))) {
            throw new InvalidDataException('base64 decoding failed');
        }

        if ( ! $base64) {
            $rawData = rawurldecode($rawData);
        }

        $dataURI = new Data($rawData, $mimeType, $dataParams, $strict, $len);
        $dataURI->setBinaryData($base64);

        return $dataURI;
    }
}
