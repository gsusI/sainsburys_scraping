<?php

class ProductCrawler extends Crawler{

    public function __construct($uri){
        $this->uri = $uri;
        parent::__construct();
    }

    public function getData(){
        //load page
        parent::loadURI();
        //get results
        $result = array();
        $result['title'] = $this->getProductTitle();
        $result['unit_price'] = $this->getUnitPrice();
        $result['description'] = $this->getProductDescription();
        $result['size'] = parent::getPageSizeInKb() . "kb";
        return $result;
    }

    //Get description or throw InvalidArgumentException if not found 
    private function getProductDescription(){
        try{
            $description = $this->crawler->filter('#information > productcontent > htmlcontent > div.productText')->text();
        }catch (InvalidArgumentException $ex){
            throw new InvalidArgumentException("Product description not found in product page");
        }
        return trim($description);
    }

    //Get product title or throw InvalidArgumentException if not found
    private function getProductTitle(){
        try{
            $title = $this->crawler->filter('#content > div.section.productContent > div.pdp > div > div.productTitleDescriptionContainer > h1')->text();
        }catch (InvalidArgumentException $ex){
            throw new InvalidArgumentException("Product title not found in product page");
        }
        return $title;
    }

    //Get product unit price or throw InvalidArgumentException if not found
    private function getUnitPrice(){
        try{
            $price = $this->sanitizePrice($this->crawler->filter('div.pricing > p.pricePerUnit')->text());
        }catch (InvalidArgumentException $ex){
            throw new InvalidArgumentException("Price not found in product page");
        }
        if($price === FALSE){
            throw new InvalidArgumentException("Price in wrong format");
        }
        return $price;
    }

    //Sanitize price text to extract the value
    private function sanitizePrice($raw){
        preg_match("#(\d+(\.\d+)?)#",$raw,$matches);
        if(count($matches)>0)
            return $matches[0];
        return FALSE;
    }

}