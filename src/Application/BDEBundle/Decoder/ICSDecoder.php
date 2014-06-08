<?php

namespace Application\BDEBundle\Decoder;

use FOS\RestBundle\Decoder\DecoderInterface;

class ICSDecoder implements DecoderInterface
{
	private function dateToCal($date)
	{
		$dateTime = new \DateTime($date);
		return $dateTime->format('Ymd\THis\Z');
	}

	private function escapeString($string) {
		return preg_replace('/([\,;])/','\\\$1', $string);
	}

    public function decode($data)
    {
        $ics = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//hacksw/handcal//NONSGML v1.0//EN\r\nCALSCALE:GREGORIAN\r\n";

		foreach ($data as $event) {
			$ics .= "BEGIN:VEVENT\r\nUID:".$event['id']."\r\nLOCATION:".$this->escapeString($event['place'])."\r\nSUMMARY:".$this->escapeString($event['title'])."\r\nDTSTART:".$this->dateToCal($event['start'])."\r\nDTEND:".$this->dateToCal($event['end'])."\r\nEND:VEVENT\r\n";
		}

		$ics .= "END:VCALENDAR\r\n";

		return $ics;
    }
}