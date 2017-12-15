<?php

/**
 * Created by PhpStorm.
 * User: PhilipB
 * Date: 12/13/17
 * Time: 11:44 PM
 */


class NewScrapeBaseController
{
    const HTTP_CODE = 'http_code';
    const HTTP_SUCCESS_CODE = 200;
    const HTTP_DATA = 'data';
    const HTTP_DL_SIZE = 'downloadSize';

    /**
     * @var
     */
    public $resourcePath;
    /**
     * @var
     */
    public $argv;

    /**
     * @var
     */
    public $validationRules;

    /**
     * @var
     */
    private $curlResponse;


    /**
     * @todo create a validation class and place this function in there
     */
    private function validateUrl()
    {
        if($this->curlResponse[self::HTTP_CODE]!= self::HTTP_SUCCESS_CODE){
            echo 'HTTP request returned false: HTTP CODE: '.$this->curlResponse[self::HTTP_CODE];
            exit();
            
        }
        
        if($this->curlResponse[self::HTTP_DL_SIZE] < 1){
            echo 'No Data at resource: Download size: '.$this->curlResponse[self::HTTP_DL_SIZE];
            exit();
        }
    }

    /**
     * @param $url
     * @return mixed
     */
    public function getContents($url)
    {
        $this->curlResponse = $this->doCurl($url);
        $this->validateUrl();
        
        return $this->curlResponse[self::HTTP_DATA];
    }

    /**
     * @param $url
     * @return mixed
     */
    public function doCurl($url)
    {
        $urlHeaders = array(

            'Accept: *',
            'Accept-Encoding: utf-8',
            'User-Agent:*',
        );

        $ch = curl_init();  // Initialising cURL
        curl_setopt($ch, CURLOPT_URL, $url);    // Setting cURL's URL option with the $url variable passed into the function
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Setting cURL's option to return the webpage data
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, '');// empty contant value to enable the cookies
        curl_setopt($ch, CURLOPT_HTTPHEADER, $urlHeaders);
        curl_setopt($ch, CURLOPT_VERBOSE, false);

        $returnArray[self::HTTP_DATA] = curl_exec($ch);
        $returnArray[self::HTTP_DL_SIZE] = curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD); // Get curl info
        $returnArray[self::HTTP_CODE] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $returnArray['redirectCount'] = curl_getinfo($ch, CURLINFO_REDIRECT_COUNT);

        curl_close($ch);

        return $returnArray;
    }
}