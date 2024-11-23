<?php
$server = "localhost";
$username = "root";
$password = "root";
$dbname = "Peerkada";
$conn = new mysqli($server, $username, $password, $dbname, 8889) or die("Unable to connect");


$sql = "SELECT * FROM members_profile";
$query = $conn->query($sql);

while ($row = $query->fetch_assoc()) {
    echo "ID: " . $row['PROFILE_ID'];
}
