/* A script to get information of a specific customer where the id is a post field*/


<?php







function customerInfo()
{
    if(isset($_POST['customerId'])) {
 $customerId = $_POST['customerId'];
} else{
    echo "Invalid customer ID";
}

    $apiKey = "81vhcdbbftogrypwbqtrjznhupnfidom";
    $endpoint = "https://api.dev.ecommerce.ontdf.io/rest/V1/customers/";
    $url = $endpoint . $customerId;

    $ch = curl_init($url);


// Setting options for the cURL session
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $apiKey,
        "Content-Type: application/json"
    ]);

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
}

function createCustomersFromCSV(){
    $rootUri = "https://api.dev.ecommerce.ontdf.io/rest/V1/customers/";
    $apiKey = "81vhcdbbftogrypwbqtrjznhupnfidom";
    $file= 'customers.csv';

    // Check if the file exists
    if (!file_exists($file)) {
        die('File does not exist');
    }

    $handle = fopen($file, 'r');

    $header = fgetcsv($handle);


    while (($row = fgetcsv($handle)) !== false) {
        $customerData = array_combine($header, $row);

        // Create a customer object
        $customer = [
            'customer' => [
                'id' => $customerData['id'],
                'firstname' => $customerData['firstname'],
                'lastname' => $customerData['lastname'],
                'email' => $customerData['email'],

            ]
        ];

        // Encode the customer object as a JSON string
        $jsonData = json_encode($customer);

        $ch = curl_init();

        // Set the options for the cURL request
        curl_setopt($ch, CURLOPT_URL, $rootUri . 'customers');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ]);

        // Execute the cURL request
        $response = curl_exec($ch);

        if ($response === false) {
            die('cURL error: ' . curl_error($ch));
        }

        // Decode the JSON response
        $data = json_decode($response, true);

        if (!isset($data['id'])) {
            die('Error creating customer: ' . $response);
        }

        // Print success
        echo 'Customer created with ID: ' . $data['id'] . PHP_EOL;
    }

    // Close the file
    fclose($handle);
}



?>