<?php

/**
 * Created by PhpStorm.
 * User: PhilipB
 * Date: 12/14/17
 * Time: 10:53 PM
 */

require 'NewsScrapeContentInterface.php';

class NewsScrapeContentHTML extends NewScrapeBaseController implements NewsScrapeContentInterface
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

    /**
     * @param array $array
     */
    private function verifyNoMissMatch(array $array)
    {
        $singleLength = $array[0];

        if(array_sum($array) != ($singleLength * count($array))){
            echo 'all are not the same '; exit();
        }
    }
    
    private function checkHasData(array $array)
    {
        if(!isset($array[0]) || empty($array[0])){
            echo 'Error: Unable to locate any node on the page. Aborted. '; exit();
        }
    }

    /**
     * Scrapes contents and organisizes in to an array
     */
    public function examineContent()
    {
        $content_doc = new DOMDocument();

        libxml_use_internal_errors(TRUE);
        $content_doc->loadHTML($this->content);
        libxml_clear_errors();
        

        $content_xpath = new DOMXPath($content_doc);

        $content_row_title = $content_xpath->query('//span[@class=\'story-title\']/a');
        $content_row_url = $content_xpath->query('//span[@class=\'story-title\']/span/a[@class=\'story-sourcelnk\']');
        $content_row_time = $content_xpath->query('//span[@class=\'story-byline\']/time');
        $content_row_summary = $content_xpath->query('//div[@class=\'body\']/div/i');
        
        
        $verifyData = [
            $content_row_title->length,
            $content_row_url->length,
            $content_row_time->length,
            $content_row_summary->length
        ];

        $this->verifyNoMissMatch($verifyData);
        $this->checkHasData($verifyData);
        
        
        $dataRow = [];

        for($i = 0; $i <= 1; $i++){

            foreach ($content_row_time as $row){

                $dataRow[$i]['date'] = $row->nodeValue;

                    $i++;
            }

            $i = 0;

            foreach ($content_row_title as $row){

                $dataRow[$i]['title'] = $row->nodeValue;

                $i++;
            }

            $i = 0;

            foreach ($content_row_summary as $row){

                $dataRow[$i]['summary'] = substr($row->nodeValue,0,100);

                $i++;
            }

            $i = 0;

            foreach ($content_row_url as $row){

                $dataRow[$i]['url'] = $row->nodeValue;

                $i++;
            }
            
            $i++;
        }
        
        echo print_r($dataRow,true); die; // @todo write to the database
    }

    /**
     * 
     */
    public function scrapeContent()
    {
        $this->content = $this->getContents($this->url);
        $this->examineContent();
    }
}