<?php

abstract class Product{
    protected $title;
    protected $description;
    protected $unitPrice;

    public function setTitle($title){
        $this->title = $title;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function setUnitPrice($unit_price){
        $this->unitPrice = $unit_price;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getDescription(){
        return $this->description;
    }
    
    public function getUnitPrice(){
        return $this->unitPrice;
    }
}