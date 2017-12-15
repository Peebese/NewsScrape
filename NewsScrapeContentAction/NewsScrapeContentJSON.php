<?php

/**
 * Created by PhpStorm.
 * User: PhilipB
 * Date: 12/14/17
 * Time: 10:54 PM
 */


class NewsScrapeContentJSON extends NewScrapeBaseController implements NewsScrapeContentInterface
{
    /**
     * @var
     */
    private $content;
    
    /**
     * @var
     */
    private $url;

    /**
     * NewsScrapeContentHTML constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }
    
    public function scrapeContent()
    {
        $this->content = $this->getContents($this->url);
        
        echo print_r($this->content, true); die;
        
    }
}