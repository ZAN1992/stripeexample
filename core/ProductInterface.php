<?php

/**
 * Interface ProductInterface
 */
interface ProductInterface {
    public function id();
    public function setProductData($product);
    public function getProduct();
    public function getPrice();
    public function getCurrency();
    public function getSKU();
    public function getPeriod();
}
