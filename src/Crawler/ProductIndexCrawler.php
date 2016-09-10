<?php
/*
* Crawler abstract class for Sainsbury's crawler.
*
*/
class ProductIndexCrawler extends Crawler{
    
    public function __construct($uri){
        $this->uri = $uri;
        parent::__construct();
    }
    public function getData(){
        //load the page
        parent::loadURI();
        //get results
        $result = array();
        try{
            //checking if element exist to throw exception, will throw exception if not.
            $this->crawler->filter('#productLister > ul > li')->text();
            //get Uri for every entry in the list
            $this->crawler->filter('#productLister > ul > li')->each(function ($node) use (&$result){
                $result[] = $node->filter('h3 > a')->link()->getUri();
            });
        }catch (InvalidArgumentException $ex){
            //Throw an exception if the list is not found
            throw new InvalidArgumentException("Product list not found in index page");
        }
        return $result;
    }

}