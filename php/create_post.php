<?php
// php/create_post.php
require 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['firebase_uid'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

// Campos
$uid = $data['firebase_uid'];
$content = $data['content'] ?? '';
$imageUrl = $data['imageUrl'] ?? null;

if (empty($content) && empty($imageUrl)) {
    echo json_encode(['success' => false, 'message' => 'El post no puede estar vacío']);
    exit;
}

try {
    // 1. Obtener ID de usuario de DB local usando firebase_uid
    $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE firebase_uid = ?");
    $stmt->execute([$uid]);
    $userRow = $stmt->fetch();

    if (!$userRow) {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado en base de datos']);
        exit;
    }

    $userId = $userRow['id_usuario'];

    // 2. Insertar Post
    $sql = "INSERT INTO publicaciones (id_usuario, contenido_texto, contenido_foto_url, fecha_publicacion) 
            VALUES (?, ?, ?, NOW())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId, $content, $imageUrl]);

    echo json_encode(['success' => true, 'message' => 'Publicado correctamente']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
