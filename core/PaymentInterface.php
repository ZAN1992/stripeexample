<?php

interface PaymentInterface {
    public function setPaymentMethod($paymentMethod = null, $cardId = null, $token = null);
    public function getPaymentMethods();
    public function getCurrentPaymentMethod();
    public function getCurrentPaymentType();
}
