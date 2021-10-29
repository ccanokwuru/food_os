<?php
$conn = mysqli_connect('localhost', 'root', '', 'food_order_system');
if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL; // Returns the error code of the last connection error
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL; // Returns a description of the last connection error
    exit;
}