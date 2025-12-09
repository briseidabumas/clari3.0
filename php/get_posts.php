<?php
// php/get_posts.php
require 'db.php';
header('Content-Type: application/json');

try {
    // JOIN posts con usuarios para obtener nombre y foto
    $sql = "SELECT 
                p.id_publicacion,
                p.contenido_texto,
                p.contenido_foto_url,
                p.fecha_publicacion,
                u.nombre_completo as userName,
                u.foto_perfil_url as userPhoto,
                u.firebase_uid
            FROM publicaciones p
            JOIN usuarios u ON p.id_usuario = u.id_usuario
            ORDER BY p.fecha_publicacion DESC
            LIMIT 50"; // Limite inicial

    $stmt = $pdo->query($sql);
    $posts = $stmt->fetchAll();

    echo json_encode(['success' => true, 'posts' => $posts]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
