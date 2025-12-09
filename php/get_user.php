<?php
// php/get_user.php
require 'db.php';
header('Content-Type: application/json');

$uid = $_GET['firebase_uid'] ?? '';

if (!$uid) {
    echo json_encode(['success' => false, 'message' => 'Falta UID']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE firebase_uid = ?");
    $stmt->execute([$uid]);
    $user = $stmt->fetch();

    if ($user) {
        echo json_encode(['success' => true, 'user' => $user]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
