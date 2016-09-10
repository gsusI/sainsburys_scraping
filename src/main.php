<?php

//Autoload all the classes needed for the tool
require_once __DIR__ . "/autoload.php";

//Set parameter requirements & needed settings
$short_options = "p:t:";
$long_options = array("page:","type:");
$options = getopt($short_options, $long_options);
$valid_types = array("fruits_index");

//Verify if the parameter page have been set in the input
if ((!isset($options['p']) && !isset($options['page'])) || (!isset($options['t']) && !isset($options['type']))){
    print_usage();
    exit();
}else if ((isset($options['p']) && !is_url($options['p'])) || (isset($options['page']) && !is_url($options['page']))){
    //TODO; give more error details
    print_usage("Sorry, the page you entered doesn't seem to be a URL, please check it and try again");
    exit();
}elseif ((!isset($options['t']) || !in_array($options['t'],$valid_types)) && (!isset($options['type']) || in_array($options['type'],$valid_types))){
    //TODO; give more error details
    print_usage("Sorry, we haven't recognized the type you specified, please check available types and try again");
    exit();
}
//Parameters to variables
$uri = (isset($options['p']) ? $options['p'] : $options['page']);
$type = (isset($options['t']) ? $options['t'] : $options['type']);
if($type == 'fruits_index'){
    $result = crawl_index($uri);
}
echo json_encode($result);
exit();

function crawl_index($uri){
    //Initialize index crawler
    $crawler = new ProductIndexCrawler($uri);
    //Get product uris in index
    $product_uris = $crawler->getData();
    $result = array('results' => array(),'total'=> 0.0);
    //Convert uris in products
    foreach($product_uris as $product_uri){
        //Crawl product from uri
        $product_crawler = new ProductCrawler($product_uri);
        $productData = $product_crawler->getData();
        //Create fruit product
        $product = new FruitProduct();
        $product->setTitle($productData['title']);
        $product->setDescription($productData['description']);
        $product->setUnitPrice($productData['unit_price']);
        //complete product with data to return
        $result['results'][] = array(
            'title' => $product->getTitle(),
            'description' => $product->getDescription(),
            'unit_price' => $product->getUnitPrice(),
            'size' => $productData['size'],
        );
        //Add the unit price to the total
        $result['total'] += $product->getUnitPrice();
    }
    return $result;
}

function print_usage($error = NULL){
    global $valid_types;
    echo '
    
  _________          .__                    ___.                               /\              
 /   _____/ _____    |__|   ____     ______ \_ |__    __ __  _______   ___.__. \(   ______   
 \_____  \  \__  \   |  |  /    \   /  ___/  | __ \  |  |  \ \_  __ \ <   |  |     /  ___/  
 /        \  / __ \_ |  | |   |  \  \___ \   | \_\ \ |  |  /  |  | \/  \___  |     \___ \     
/_______  / (____  / |__| |___|  / /____  >  |___  / |____/   |__|     / ____|    /____  >    
        \/       \/            \/       \/       \/                    \/              \/   
+------------------------------------------------------------------------------------------+
+------------------------------------------------------------------------------------------+

    This tool have been developed by Jesus Iniesta for Sainsbury\'s techincal interview

    How to use it:

        -p, --page: Index URL to scrape
        -t, --type: Type of data to process
            accepted types: "' . implode('", "', $valid_types) . '"

    ' . PHP_EOL;
    if($error){
        echo '

    ERROR:

        '. $error . '

        ' . PHP_EOL;
    }
}

function is_url($input){
    return preg_match('#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i',$input) == 1;
}
