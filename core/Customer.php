<?php

/**
 * Class Customer
 */
abstract class Customer implements CustomerInterface {

    /**
     * Customer ID
     *
     * @var string
     */
    protected $id;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * Customer payment method
     *
     * @var object|string|null
     */
    private $paymentMethod;

    /**
     * Payment method type
     *
     * @var string
     */
    private $paymentType;

    /**
     * Customer full name
     *
     * @var string|null $name
     */
    private $name;

    /**
     * Customer email
     *
     * @var string $email
     */
    private $email;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setPaymentMethod($payment_method = null, $card_id = null, $token = null)
    {
        if ($payment_method) {
            $this->paymentType = 'card';
            $this->paymentMethod = $payment_method;
        }
        elseif ($card_id) {
            $this->paymentType = 'card';
            $this->paymentMethod = $card_id;
        }
        elseif ($token) {
            $this->paymentType = 'source';
            $this->paymentMethod = $token;
        }

        return $this;
    }

    public function getCurrentPaymentMethod()
    {
        return $this->paymentMethod;
    }

    public function getCurrentPaymentType()
    {
        return $this->paymentType;
    }

    public function setCustomerData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getCustomer()
    {
        return $this;
    }

    public function getCustomerData()
    {
        return $this->data;
    }
}
