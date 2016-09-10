<?php

class CrawlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            main
     * @uses              Crawler
     * @uses              ProductIndexCrawler
     * @uses              ProductCrawler
     * @uses              Product
     * @uses              FruitProduct
     */
     public function testCorrectInput(){
         exec("php ". __DIR__ ."/../../src/main.php --page 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html'  -t fruits_index", $output);
        $output = json_decode($output[0], TRUE);
        $this->assertNotEquals(NULL, $output);
        $this->assertArrayHasKey('results',$output);
        $this->assertArrayHasKey('total',$output);
     }
}