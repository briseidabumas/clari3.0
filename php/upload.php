<?php
// php/upload.php
header('Content-Type: application/json');

if (!isset($_FILES['file'])) {
    echo json_encode(['success' => false, 'message' => 'No se subió archivo']);
    exit;
}

$file = $_FILES['file'];
$uploadDir = '../uploads/';

// Crear directorio si no existe (aunque ya lo creé con comando)
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Generar nombre único
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid() . '.' . $ext;
$targetPath = $uploadDir . $filename;

// Mover archivo
if (move_uploaded_file($file['tmp_name'], $targetPath)) {
    // Retornar la ruta relativa accesible desde el navegador
    $webPath = 'uploads/' . $filename;
    echo json_encode(['success' => true, 'url' => $webPath]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar archivo']);
}
?>
