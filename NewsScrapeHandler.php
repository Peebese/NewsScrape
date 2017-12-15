<?php

/**
 * Created by PhpStorm.
 * User: PhilipB
 * Date: 12/14/17
 * Time: 4:50 AM
 */
require 'NewScrapeBaseController.php';
require 'NewsScrapeContentAction/NewsScrapeContentHTML.php';
require 'NewsScrapeContentAction/NewsScrapeContentJSON.php';
require 'NewsScrapeContentAction/NewsScrapeContentXML.php';


class NewsScrapeHandler extends NewScrapeBaseController
{ 
    const EMPTY_URL = 'Url cannot be empty';
    const EMPTY_CONTENT_TYPE = 'Content Type Cannot be empty';
    const CONTENT_TYPE_ERROR = 'Invalid Content Type. HTML, XML or JSON';
    
    const CONTENT_HTML  = 'html';
    const CONTENT_XML   = 'xml';
    const CONTENT_JSON  = 'json';

    /**
     * @var array
     */
    public $errors = [];

    /**
     * @var
     */
    public $url;
    
    /**
     * @var
     */
    private $contentType;

    /**
     * NewsScrapeHandler constructor.
     * @param $argv
     */
    public function __construct($argv = [])
    {
        $this->argv = $argv;
    }

    /**
     * @return bool
     */
    public function validateRequest()
    {
        if($this->getRequest() == false ){
            return false;
        }
        
        $validContent = ['html','xml','json'];
        
        if(!in_array(strtolower($this->argv[2]),$validContent)){
            $this->errors[] = self::CONTENT_TYPE_ERROR;
        }
        
        return true;
    }
    
    
    public function validateUrl()
    {
        
    }

    /**
     * @return bool
     */
    private function getRequest()
    {
        if(!isset($this->argv[1])){
            $this->errors[] = self::EMPTY_URL;
            
        } else {
            $this->url = $this->argv[1];
        }

        if(!isset($this->argv[2])){
            $this->errors[] = self::EMPTY_CONTENT_TYPE;
            
        } else {
            $this->contentType = strtolower($this->argv[2]);
        }
        
        return empty($this->errors)? true : false;
    }

    /**
     * 
     */
    public function routeContentScrape()
    {
        switch ($this->contentType){
            
            case self::CONTENT_HTML:
                
                $contentData = new NewsScrapeContentHTML($this->url);
                $contentData->scrapeContent();
                
                break;
            
            case self::CONTENT_JSON:
                
                $contentData = new NewsScrapeContentJSON($this->url);
                $contentData->scrapeContent();

                break;
            
            case self::CONTENT_XML:

                $contentData = new NewsScrapeContentXML($this->url);
                $contentData->scrapeContent();

                break;
            
            default:
        }
    }
    
}