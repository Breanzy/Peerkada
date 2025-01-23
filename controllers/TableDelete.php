<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profile_id = $_POST['profile_id'];

    try {
        $deleteQuery = "DELETE FROM members_profile WHERE PROFILE_ID = :profile_id"; // Adjust table name as needed
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
