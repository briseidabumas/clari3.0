<?php
// php/sync_user.php
require 'db.php';

header('Content-Type: application/json');

// Recibir datos JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['firebase_uid']) || !isset($data['email'])) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos']);
    exit;
}

$uid = $data['firebase_uid'];
$email = $data['email'];
$name = $data['displayName'] ?? 'Usuario';
$photo = $data['photoURL'] ?? '';

try {
    // 1. Verificar si el usuario ya existe
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE firebase_uid = ?");
    $stmt->execute([$uid]);
    $user = $stmt->fetch();

    if ($user) {
        // Usuario existe: devolver datos
        echo json_encode(['success' => true, 'user' => $user, 'is_new' => false]);
    } else {
        // Usuario nuevo: insertar
        // Generar un nombre de usuario único basado en el email
        $username = explode('@', $email)[0] . rand(100, 999);
        
        $sql = "INSERT INTO usuarios (firebase_uid, nombre_usuario, nombre_completo, correo, foto_perfil_url, fecha_registro) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$uid, $username, $name, $email, $photo]);
        
        // Obtener el ID insertado
        $newId = $pdo->lastInsertId();
        
        // Devolver el nuevo usuario
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$newId]);
        $newUser = $stmt->fetch();
        
        echo json_encode(['success' => true, 'user' => $newUser, 'is_new' => true]);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
