

/* trying to mimic a real project including a database and returning the result instead of just writing the query*/


<?php
include ("../includes/db.php");


function get_customer_orders($pdo) {
  try {
    $query = "SELECT customer_entity.email, sales_order.grand_total, sales_order.created_at
              FROM customer_entity
              JOIN sales_order ON customer_entity.entity_id = sales_order.customer_id
              JOIN store ON sales_order.store_id = store.store_id
              WHERE store.name = 'LBC FR-FR'
              AND sales_order.status = 'processing'
              AND customer_entity.email LIKE 'odevelop%'
              AND DATE_FORMAT(sales_order.created_at, '%Y-%m') = '2022-12'
              ORDER BY sales_order.created_at DESC";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

$result = get_customer_orders($pdo);
foreach($result as $row) {
  echo "Email: " . $row['email'] . " Grand Total: " . $row['grand_total'] . " Order Date: " . $row['created_at'] . "<br>";
}



function get_customer_orders_by_month($pdo) {
    try {
        $query = "SELECT DATE_FORMAT(customer_entity.created_at, '%Y-%m') as customer_created, customer_entity.entity_id, customer_entity.email, 
              DATE_FORMAT(sales_order.created_at, '%Y-%m') as order_month, 
              COUNT(sales_order.entity_id) as total_orders, 
              SUM(sales_order.grand_total) as total_amount
              FROM customer_entity
              JOIN sales_order ON customer_entity.entity_id = sales_order.customer_id
              WHERE sales_order.store_id = 4
              AND (sales_order.status = 'complete' OR sales_order.status = 'processing' OR sales_order.status = 'closed')
              GROUP BY customer_created, order_month, customer_entity.entity_id, customer_entity.email
              ORDER BY customer_created, order_month";

        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$result = get_customer_orders_by_month($pdo);
foreach($result as $row) {
    echo "Customer Created: " . $row['customer_created'] . " Customer ID: " . $row['entity_id'] . " Email: " . $row['email'] .
        " Order Month: " . $row['order_month'] . " Total Orders: " . $row['total_orders'] . " Total Amount: " . $row['total_amount'] . "<br>";
}
?>
