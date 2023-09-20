<?php

/**
 * Class CustomerStripe
 */
class CustomerStripe extends Customer {
    /**
     * @var \Stripe\Stripe
     */
    private $stripe;

    /**
     * @var \Stripe\Subscription
     */
    protected $subscriptionData;

    /**
     * CustomerStripe constructor.
     * @param \Stripe\StripeClient $stripe
     */
    public function __construct(\Stripe\StripeClient $stripe) {
        $this->stripe = $stripe;
    }

    public function id()
    {
        return $this->id;
    }

    public function setPaymentMethod($payment_method = null, $card_id = null, $token = null)
    {
        parent::setPaymentMethod($payment_method, $card_id, $token);
        if ($token && $this->id) {
            $this->data = $this->stripe->customers->update($this->id, [
                'source' => $token,
            ]);
        }

        return $this;
    }
    /**
     * Get customer
     *
     * @param string $email
     *
     * @param string $name
     * @param null $token
     *
     * @return $this
     */
    public function searchOrCreateCustomer($email, $name = '', $token = null) {
        if (!($customer = $this->data)) {
            /** @var \Stripe\SearchResult $customer */
            $customer =  $this->stripe->customers->search([
                'query' => "email:'$email'",
            ]);
            $customer = $customer->first();

            if (!$customer || !$customer->count()) {
                /** @var \Stripe\Customer $customer */
                $customer = $this->stripe->customers->create(
                    [
                        'name' => $name,
                        'email' => $email,
                        'source' => $token,
                    ],
                    [
                        'idempotency_key' => uniqid('', true),
                    ]
                );
            }
            // Set customer in object
            $this->setData($customer);
        }

        return $this;
    }


    /**
     * Get all payment methods from customer
     *
     * @return array|null
     */
    public function getPaymentMethods()
    {
        if ($this->id === null) {
            return null;
        }

        return $this->stripe->customers->allPaymentMethods(
            $this->id,
            ['type' => 'card']
        );
    }

    protected function setData($customer) {
        if ($customer instanceof \Stripe\Customer) {
            $this->data = $customer;
            $this->id = $customer->id;
            $this->setName($customer->name);
            $this->setEmail($customer->email);
        }

        return $this;
    }

    public function setSubscription($email, $product, $start_at = null, $end_at = null)
    {
        $customer = $this->searchOrCreateCustomer($email);
        $this->subscriptionData = $this->stripe->subscriptions->create([
            'customer' => $customer->id(),
            'cancel_at_period_end' => false,
            'metadata' => [
                'product' => $product->getSku(),
                'order_id' => uniqid('#'),
                'status' => true,
            ],
            'items' => [
                [
                    'quantity' => 1,
                    'price_data' => [
                        'currency' => $product->getCurrency(),
                        'product' => $product->id(),
                        'recurring' => [
                            'interval' => $product->getPeriod()
                        ],
                        'unit_amount' => $product->getPrice() * 100,
                    ],
                ],
            ],
            //'cancel_at' => $end_at, //subscription cancellation time
        ]);

        return $this;
    }

    public function getSubscriptionData()
    {
        return $this->subscriptionData;
    }

    public function getSubscriptions()
    {
        return $this->stripe->subscriptions->all();
    }

    public function removeSubscription($subscription_id)
    {
        return $this->stripe->subscriptions->cancel(
            $subscription_id,
            []
        );
    }

    public function searchSubscriptionByOrderID($order_id)
    {
        $status = SubscriptionInterface::STATUS_ACTIVE;
        $subscription = $this->stripe->subscriptions->search([
            'query' => "status:'{$status}' AND metadata['order_id']:'{$order_id}'",
        ]);

        return $subscription;
    }
}
