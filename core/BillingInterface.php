<?php

/**
 * Interface BillingInterface
 */
interface BillingInterface extends PaymentInterface {
    public function send();

    public function setCustomer(CustomerInterface $customer);
    public function getCustomer();

    public function setProduct(ProductInterface $product);
    public function getProduct();
}
