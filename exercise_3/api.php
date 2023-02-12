/* A script to retriew information of a specific customer where the id is a post field*/


<?php

// API endpoint URI
$endpoint = "https://api.dev.ecommerce.ontdf.io/rest/V1/customers/";

$customerId = $_POST['customerId'];

// API Key
$apiKey = "81vhcdbbftogrypwbqtrjznhupnfidom";

$url = $endpoint . $customerId;

$ch = curl_init($url);

// Setting options for the cURL session
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $apiKey,
    "Content-Type: application/json"
]);

// Executing the cURL session
$response = curl_exec($ch);

curl_close($ch);

// Decoding the JSON response
$customer = json_decode($response, true);

// Checking if the customer ID exists
if (!empty($customer)) {
    // Customer ID exists
    echo "Customer Information: <br>";
    echo "ID: " . $customer['id'] . "<br>";
    echo "First Name: " . $customer['firstname'] . "<br>";
    echo "Last Name: " . $customer['lastname'] . "<br>";
    echo "Email: " . $customer['email'] . "<br>";

} else {
    // Customer ID does not exist
    echo "Error: Customer with ID " . $customerId . " does not exist.";
}

?>