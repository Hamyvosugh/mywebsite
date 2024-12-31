<?php
require 'vendor/autoload.php'; // Ensure the MongoDB library is autoloaded via Composer

// MongoDB connection credentials
$username = urlencode("hamyvosugh");
$password = urlencode("Sedayema@6283");

// Connect to MongoDB
try {
    $client = new MongoDB\Client("mongodb+srv://{$username}:{$password}@cluster0.fotfi.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
    $collection = $client->myFirstDatabase->messages;

    // Fetch all documents from the collection
    $cursor = $collection->find();

    // Display the data in an HTML table
    echo "<h1>Messages from MongoDB</h1>";
    echo "<table border='1'>
            <tr>
                <th>Message</th>
                <th>Date</th>
                <th>Time</th>
            </tr>";

    foreach ($cursor as $document) {
        echo "<tr>";
        echo "<td>" . $document['message'] . "</td>";
        echo "<td>" . $document['date'] . "</td>";
        echo "<td>" . $document['time'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>