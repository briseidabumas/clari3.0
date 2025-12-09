<?php
// php/get_my_posts.php
require 'db.php';
header('Content-Type: application/json');

$uid = $_GET['firebase_uid'] ?? '';

if (!$uid) {
    echo json_encode(['success' => false, 'message' => 'Falta UID']);
    exit;
}

try {
    // JOIN posts con usuarios para validar y ordenar
    $sql = "SELECT 
                p.id_publicacion,
                p.contenido_texto,
                p.contenido_foto_url,
                p.fecha_publicacion,
                u.nombre_completo as userName,
                u.foto_perfil_url as userPhoto
            FROM publicaciones p
            JOIN usuarios u ON p.id_usuario = u.id_usuario
            WHERE u.firebase_uid = ?
            ORDER BY p.fecha_publicacion DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$uid]);
    $posts = $stmt->fetchAll();

    echo json_encode(['success' => true, 'posts' => $posts]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
