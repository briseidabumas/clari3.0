<?php
// php/update_profile.php
require 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['firebase_uid'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$uid = $data['firebase_uid'];
$updates = [];
$params = [];

// Construir query dinámica
if (isset($data['displayName'])) {
    $updates[] = "nombre_completo = ?";
    $params[] = $data['displayName'];
}
if (isset($data['photoURL'])) {
    $updates[] = "foto_perfil_url = ?";
    $params[] = $data['photoURL'];
}
// Podríamos añadir cover si hubiese columna en DB, pero schema no tiene cover.
// Si el usuario quiere cover, tendría que alterar la tabla. Por ahora no lo haré.

if (empty($updates)) {
    echo json_encode(['success' => true, 'message' => 'Nada que actualizar']);
    exit;
}

$params[] = $uid; // Para el WHERE

try {
    $sql = "UPDATE usuarios SET " . implode(', ', $updates) . " WHERE firebase_uid = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo json_encode(['success' => true, 'message' => 'Perfil actualizado']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
