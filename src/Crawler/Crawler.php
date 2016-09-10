<?php
/*
* Crawler abstract class
*/

use Goutte\Client;

abstract class Crawler{

    protected $client;
    protected $crawler;
    protected $uri;

    public function __construct(){
        $this->client = new Client();
    }

    public abstract function getData();

    //Load the page by making a request to the previously set uri
    protected function loadURI($method = 'GET', $data = NULL){
        //TODO: for POST requests allow request data
        $this->crawler = $this->client->request($method, $this->uri);
    }
    
    //Get the size in KB of the latest page loaded, it's done using Contect-Lenght field in the request
    public function getPageSizeInKb(){
        return round($this->client->getInternalResponse()->getHeader('Content-Length')/1024, 1);
    }
}