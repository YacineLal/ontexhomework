
<?php

use PHPUnit\Framework\TestCase;

class CustomerInformationTest extends TestCase
{
    public function customerSuccess()
    {
        $apiKey = "81vhcdbbftogrypwbqtrjznhupnfidom";
        $endpoint = "https://api.dev.ecommerce.ontdf.io/rest/V1/customers/";
        $customerId = $_POST['customerId'];

        $customer = getCustomerInformation($customerId, $apiKey, $endpoint);

        $this->assertArrayHasKey('id', $customer);
        $this->assertArrayHasKey('firstname', $customer);
        $this->assertArrayHasKey('lastname', $customer);
        $this->assertArrayHasKey('email', $customer);

        $this->assertEquals($customer['id'], $customerId);
    }

    public function  customerNotFound()
    {
        $apiKey = "81vhcdbbftogrypwbqtrjznhupnfidom";
        $endpoint = "https://api.dev.ecommerce.ontdf.io/rest/V1/customers/";
        $customerId = $_POST['customerId'];

        $customer = getCustomerInformation($customerId, $apiKey, $endpoint);

        $this->assertEmpty($customer);
    }
}