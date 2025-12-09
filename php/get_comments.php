<?php
// php/get_comments.php
require 'db.php';
header('Content-Type: application/json');

$postId = $_GET['post_id'] ?? '';

if (!$postId) {
    echo json_encode(['success' => false, 'message' => 'Falta Post ID']);
    exit;
}

try {
    $sql = "SELECT 
                c.id_comentario,
                c.contenido_texto,
                c.fecha_comentario,
                u.nombre_completo as userName,
                u.foto_perfil_url as userPhoto
            FROM comentarios c
            JOIN usuarios u ON c.id_usuario = u.id_usuario
            WHERE c.id_publicacion = ?
            ORDER BY c.fecha_comentario ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$postId]);
    $comments = $stmt->fetchAll();

    echo json_encode(['success' => true, 'comments' => $comments]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
