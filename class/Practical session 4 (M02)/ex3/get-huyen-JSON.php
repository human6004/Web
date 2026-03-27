<?php
header('Content-Type: application/json; charset=utf-8');
require "connect-select-db.php";

$output = [];

if (isset($_GET['matinh']) && $_GET['matinh'] !== '') {
    $matinh = (int)$_GET['matinh'];

    $stmt = $conn->prepare("SELECT mahuyen, tenhuyen FROM huyen WHERE matinh = ? ORDER BY tenhuyen");
    $stmt->bind_param("i", $matinh);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $output[] = [
            'mahuyen' => $row['mahuyen'],
            'tenhuyen' => $row['tenhuyen']
        ];
    }

    $stmt->close();
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
$conn->close();
?>