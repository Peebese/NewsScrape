#!/usr/bin/php

<?php

/**
 * Created by PhpStorm.
 * User: PhilipB
 * Date: 12/13/17
 * Time: 11:20 PM
 */

require 'NewsScrapeHandler.php';

class NewsScrape extends NewScrapeBaseController
{
    /**
     * NewsScrape constructor.
     */
    public function __construct()
    {
        $this->argv = $_SERVER['argv'];
    }

    /**
     * 
     */
    public function scrapeResource()
    {
        $handler = new NewsScrapeHandler($this->argv);
        $handler->validateRequest();
        $errors = $handler->errors;
        
        if(!empty($errors)){
            
            foreach ($errors as $error) {
                echo $error.PHP_EOL;
            }
            exit();
        }
        
        $handler->routeContentScrape();
        
    }
}

$scrape = new NewsScrape();
$scrape->scrapeResource();