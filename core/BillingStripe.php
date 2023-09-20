<?php

/**
 * Class BilingStripe
 */
class BillingStripe extends Billing {
    /**
     * @var \Stripe\Stripe
     */
    private $stripe;

    /**
     * CustomerStripe constructor.
     * @param \Stripe\StripeClient $stripe
     */
    public function __construct(\Stripe\StripeClient $stripe) {
        $this->stripe = $stripe;
    }

    public function send()
    {
        $customer = $this->getCustomer();
        /** @var ProductInterface $product */
        $product = $this->getProduct();
        $res = $this->stripe->charges->create([
            'amount' => $product->getPrice() * 100,
            'currency' => $product->getCurrency(),
            //'source' => $token,
            'customer' => $customer->id(),
        ]);

        return (bool)$res->paid;
    }
}
