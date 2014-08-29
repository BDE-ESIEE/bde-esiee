<?php

namespace Application\LinkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Link
 */
class Link
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $url;

    private $generatedUrl;

    public function __construct()
    {
        $this->token = $this->generateToken();
        $this->generatedUrl = '';
    }

    public function __toString()
    {
        return ''.$this->getUrl();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Link
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set generatedUrl
     *
     * @param string $generatedUrl
     * @return Link
     */
    public function setGeneratedUrl($generatedUrl)
    {
        $this->generatedUrl = $generatedUrl;

        return $this;
    }

    /**
     * Get generatedUrl
     *
     * @return string 
     */
    public function getGeneratedUrl()
    {
        return $this->generatedUrl;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    private function generateToken($limit = 10)
    {
        $token = '';

        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $list = str_split($chars);
        $len = count($list) - 1;
        $i = 0;

        do {
            $i++;
            $index = rand(0, $len);
            $token .= $list[$index];
        } while ($i < $limit);

        return $token;
    }
}
