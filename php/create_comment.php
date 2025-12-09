<?php
// php/create_comment.php
require 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['firebase_uid']) || !isset($data['post_id']) || !isset($data['content'])) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos']);
    exit;
}

$uid = $data['firebase_uid'];
$postId = $data['post_id'];
$content = trim($data['content']);

if (empty($content)) {
    echo json_encode(['success' => false, 'message' => 'El comentario no puede estar vacío']);
    exit;
}

try {
    // 1. Obtener ID de usuario local
    $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE firebase_uid = ?");
    $stmt->execute([$uid]);
    $userRow = $stmt->fetch();

    if (!$userRow) {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        exit;
    }

    $userId = $userRow['id_usuario'];

    // 2. Insertar Comentario
    $sql = "INSERT INTO comentarios (id_publicacion, id_usuario, contenido_texto, fecha_comentario) 
            VALUES (?, ?, ?, NOW())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$postId, $userId, $content]);

    // Devolver éxito (y quizás el comentario insertado si quisiéramos ser fancy, pero reloading es más fácil)
    echo json_encode(['success' => true, 'message' => 'Comentario agregado']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
