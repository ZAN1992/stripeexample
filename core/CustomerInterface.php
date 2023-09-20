<?php

interface CustomerInterface extends SubscriptionInterface, PaymentInterface {
    public function id();

    public function getName();
    public function setName($name);

    public function getEmail();
    public function setEmail($email);

    public function searchOrCreateCustomer($email);

}
