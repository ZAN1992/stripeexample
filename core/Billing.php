<?php

/**
 * Class Billing
 */
abstract class Billing implements BillingInterface {
    protected $paymentMethod;
    protected $paymentType;

    private $customer;
    private $product;

    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return CustomerInterface|null
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    public function setPaymentMethod($payment_method = null, $card_id = null, $token = null)
    {
        $customer = $this->getCustomer();
        $customer->setPaymentMethod($payment_method, $card_id, $token);
        $this->paymentMethod = $customer->getCurrentPaymentMethod();
        $this->paymentType = $customer->getCurrentPaymentType();

        return $this;
    }

    public function getCurrentPaymentMethod()
    {
        $this->paymentMethod;
    }

    public function getCurrentPaymentType()
    {
        $this->paymentType;
    }

    public function getPaymentMethods()
    {
        return $this->getCustomer()->getPaymentMethods();
    }

    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;
        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function send()
    {
        $payment = $this->getCustomer()->getCurrentPaymentMethod();
        // throw exception PaymentMethodEmpty
        if ($payment) {
            return parent::send();
        }

        return false;
    }
}
