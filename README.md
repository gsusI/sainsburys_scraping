#Sainsbury's Technical Interview Code

##Requirements
* Goutte-v2.0.4:
    [Goutte](https://github.com/FriendsOfPHP/Goutte) is the third party crawler used to scrape data
    Is included via composer.json
    Version 2.0.4 is used to make it compatible with PHP 5.4+
    To install dependencies please run the command 
    `composer install`
*  [phpunit](https://phpunit.de/getting-started.html)
   Hint: In ubuntu 16.04 you can do sudo apt install phpunit
   
##Running tests

###Unit tests

* phpunit --bootstrap src/autoload.php tests/unit/Crawler/ProductCrawlerTest.php
* phpunit --bootstrap src/autoload.php tests/unit/Crawler/ProductIndexCrawlerTest.php
* phpunit --bootstrap src/autoload.php tests/unit/MainTest.php
**Need to test other parts of the code than the crawlers**

##Using the tool

* Expected parameters:
   * -p, --page: Index URL to scrape
   * -t, --type: Type of data to process
   * No parameters for showing help
* Example command:
   * php src/main.php --page 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html'  -t fruits_index

##TODOS
* Implement behavioural tests
* Move all CSS Selectors to a config file / enum class




