<?php

// Interfaces
require_once __DIR__ . '/PaymentInterface.php';
require_once __DIR__ . '/SubscriptionInterface.php';
require_once __DIR__ . '/BillingInterface.php';
require_once __DIR__ . '/CustomerInterface.php';
require_once __DIR__ . '/ProductInterface.php';

// Classes
require_once __DIR__ . '/Billing.php';
require_once __DIR__ . '/BillingDB.php';
require_once __DIR__ . '/BillingStripe.php';
require_once __DIR__ . '/Customer.php';
require_once __DIR__ . '/CustomerDB.php';
require_once __DIR__ . '/CustomerStripe.php';
require_once __DIR__ . '/Product.php';

/**
 * Main Application class
 */
class App {
    private function __construct($data)
    {
    }

    private function __wakeup()
    {
    }

    private function __sleep()
    {
    }

    public static function createOrderWithSubscription($connectionDB, $connectionStripe, $data)
    {
        $customerName = $data['name'];
        $customerEmail = $data['email'];
        $paymentMethod = $data['payment'];
        $cardId = $data['card_id'];
        $token = $data['stripeToken'];
        $productData = $data['product'];

        // Init customer
        try {
            $customer = new CustomerStripe($connectionStripe);
            $customer = $customer->searchOrCreateCustomer($customerEmail, $customerName, $token);
            $customer->setPaymentMethod($paymentMethod, $cardId, $token);

            // Create product
            $product = new Product($connectionStripe);
            $product->setProductData($productData);

            // Create billing
            $billing = new BillingStripe($connectionStripe);
            $billing->setProduct($product);
            $billing->setCustomer($customer);
            $paid = $billing->send();

            // Customer subscription
            if ($paid) {
                $customer->setSubscription($customerEmail, $product, time(), time() + 360);
            }
        }
        catch (Exception $ex) {
            // Add logger
            $error = $ex->getMessage();
        }
     }

     // Close a Stripe subscription
    public static function cancelSubscriptionApi($connectionDB, $connectionStripe, $data)
    {
        $customerEmail = $data['email'];
        $customerSubID = $data['subscription_id'];

        try {
            $customer = new CustomerStripe($connectionStripe);
            $customer = $customer->searchOrCreateCustomer($customerEmail);
            $customer->removeSubscription($customerSubID);
        }
        catch (Exception $ex) {
            // Add logger
            $error = $ex->getMessage();
        }
    }

    public static function eventListener($wh_key, $payload, $sig_header)
    {
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $wh_key
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        switch ($event->type) {
            case 'charge.expired':
            case 'charge.failed':
            case 'charge.pending':
                // Send an email to the customer message with additional information
                // Change customer 'status' in the DataBase(change access*)
                // Change subscription 'status' in the DataBase(change access*)
                break;
            case 'customer.subscription.deleted':
                // Change subscription 'status' in the DataBase(change access*)
                break;
            case 'customer.subscription.paused':
                // Send an email to the customer message with additional information
                // Change customer 'status' in the DataBase(change access*)
                // Change subscription 'status' in the DataBase(change access*)
                break;
            case 'customer.subscription.trial_will_end':
                // Send an email to the customer message about the end of the trial version
                // Change customer 'status' in the DataBase(change access*)
                // Change subscription 'status' in the DataBase(change access*)
                break;
            case 'customer.subscription.updated':
                // Send success message after update
                break;
            case 'subscription_schedule.aborted':
                // Send an email to the customer message about subscription aborted
                // Change subscription 'status' in the DataBase(change access*)
                break;
            case 'subscription_schedule.canceled':
                // Send an email to the customer message about subscription canceled
                // Change subscription 'status' in the DataBase(change access*)
                break;
            case 'subscription_schedule.expiring':
                // Send an email to the customer message with about the expiration of the subscription
                // Move customer to cron and repeat message with expiration info
                break;
            case 'subscription_schedule.updated':
                // Success message after update
                break;
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }
}
