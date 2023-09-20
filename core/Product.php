<?php

/**
 * Class Product
 */
class Product implements ProductInterface {

    const CURRENCY = 'usd';

    /**
     * @var array|null
     */
    private $data;

    /**
     * @var \Stripe\Stripe
     */
    private $stripe;

    /**
     * @var string
     */
    private $id;

    /**
     * CustomerStripe constructor.
     * @param \Stripe\StripeClient $stripe
     */
    public function __construct(\Stripe\StripeClient $stripe) {
        $this->stripe = $stripe;
    }

    public function setProductData($data)
    {
        $this->data = $data;
        $this->init();

        return $this;
    }

    public function getProduct()
    {
        return $this->data;
    }

    public function getPrice()
    {
        return $this->data['price'];
    }

    public function getCurrency()
    {
        return static::CURRENCY;
    }

    public function getSKU()
    {
        return $this->data['name'];
    }

    public function getPeriod()
    {
        return $this->data['period'];
    }

    public function id()
    {
        return $this->id;
    }

    protected function init()
    {
        $product = $this->stripe->products->search([
            'query' => "active:'true' AND metadata['product']:'{$this->getSKU()}'",
        ]);

        if ($product->count() === 0) {
            $product = $this->stripe->products->create([
                'name' => $this->getSKU(),
                'metadata' => [
                    'product' => $this->getSKU(),
                ]
            ]);
        }
        else {
            $product = $product->first();
        }

        $this->id = $product->id;

        return $product;
    }
}
