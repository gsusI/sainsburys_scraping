<?php


class CrawlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            ProductCrawler::__construct
     * @covers            ProductCrawler::getData
     * @uses              ProductCrawler
     * @uses              Crawler
     * @expectedException InvalidArgumentException
     */
     public function testExceptionIsRaisedForProductWithMissingParameters(){
         $productCrawler = new ProductCrawler("http://www.sainsburys.co.uk");
         $productCrawler->getData();
     }
     
    /**
     * @covers            ProductCrawler::__construct
     * @covers            ProductCrawler::getData
     * @uses              Crawler
     * @uses              ProductCrawler
     */
     public function testCanGetProductParameters(){
         $productCrawler = new ProductCrawler("http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocado-xl-pinkerton-loose-300g.html");
         $productCrawler->getData();
     }
}