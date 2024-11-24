<?php
require 'config.php';

$stmt = $pdo->query("SELECT * FROM members_profile WHERE ID_NUMBER = '$text'");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: " . $row['PROFILE_ID'];
    echo "ID: " . $row['PASSWORD'];
}
