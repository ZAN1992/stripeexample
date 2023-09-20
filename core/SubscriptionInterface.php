<?php

interface SubscriptionInterface {
    const STATUS_ACTIVE = 'active';
    const STATUS_INCOMPLETE = 'incomplete';
    const STATUS_INCOMPLETE_EXPIRED = 'incomplete_expired';
    const STATUS_TRIALING = 'trialing';
    const STATUS_CANCELED = 'canceled';
    const STATUS_UNPAID = 'unpaid';

    public function setSubscription($email, $product, $start_at = null, $end_at = null);
    public function getSubscriptionData();
    public function getSubscriptions();
    public function removeSubscription($subscription_id);
    public function searchSubscriptionByOrderID($order_id);
}
