<?php

namespace Application\BDEBundle\Decoder;

use FOS\RestBundle\Decoder\DecoderInterface;

class ICSDecoder implements DecoderInterface
{
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
        $ics = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//BDE ESIEE Paris//FR\r\nX-WR-CALNAME:Evénements du BDE\r\nX-WR-TIMEZONE:Europe/Paris\r\nCALSCALE:GREGORIAN\r\n";

		foreach ($data as $event) {
			$ics .= "BEGIN:VEVENT\r\nUID:".$event['id']."\r\nLOCATION:".$this->escapeString($event['place'])."\r\nSUMMARY:".$this->escapeString($event['title'])."\r\nDTSTART;TZID=Europe/Paris:".$this->dateToCal($event['start'])."\r\nDTEND;TZID=Europe/Paris:".$this->dateToCal($event['end'])."\r\nEND:VEVENT\r\n";
		}

		$ics .= "END:VCALENDAR";

		return $ics;
    }
}