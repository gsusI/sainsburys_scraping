<?php

class CrawlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            ProductIndexCrawler::__construct
     * @covers            ProductIndexCrawler::getData
     * @uses              ProductIndexCrawler
     * @uses              Crawler
     * @expectedException InvalidArgumentException
     */
     public function testExceptionIsRaisedForListNotFound(){
         $productIndexCrawler = new ProductIndexCrawler("http://www.sainsburys.co.uk");
         $productIndexCrawler->getData();
     }
     
    /**
     * @covers            ProductIndexCrawler::__construct
     * @covers            ProductIndexCrawler::getData
     * @uses              Crawler
     * @uses              ProductIndexCrawler
     */
     public function testListContainAtLeastOneElement(){
         $productIndexCrawler = new ProductIndexCrawler("http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html");
         $product_uris = $productIndexCrawler->getData();
         $this->assertArrayHasKey(0,$product_uris);
     }

    /**
     * @covers            ProductIndexCrawler::__construct
     * @covers            ProductIndexCrawler::getData
     * @covers            ProductCrawler::getData
     * @uses              Crawler
     * @uses              ProductIndexCrawler
     * @uses              ProductCrawler
     */
     public function testListLinksToAbleToBuildProducts(){
         $productIndexCrawler = new ProductIndexCrawler("http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html");
         $product_uris = $productIndexCrawler->getData();
         $this->assertArrayHasKey(0,$product_uris);
         $productCrawler = new ProductCrawler($product_uris[0]);
         $productCrawler->getData();
     }
}