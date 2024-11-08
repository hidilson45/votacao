<?php
include '../includes/db.php'; // Inclui a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $candidato = $_POST['candidato'];

    // Armazenar o voto no banco de dados
    $stmt = $pdo->prepare("INSERT INTO votos (candidato) VALUES (:candidato)");
    $stmt->bindParam(':candidato', $candidato);
    $stmt->execute();

    // Calcular as percentagens dos votos
    $stmt = $pdo->prepare("SELECT candidato, COUNT(*) as votos FROM votos GROUP BY candidato");
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Total de votos
    $stmt = $pdo->prepare("SELECT COUNT(*) as total_votos FROM votos");
    $stmt->execute();
    $totalVotos = $stmt->fetch(PDO::FETCH_ASSOC)['total_votos'];

    $percentagens = [];
    foreach ($resultados as $resultado) {
        $percentagem = ($resultado['votos'] / $totalVotos) * 100;
        $percentagens[] = [
            'candidato' => $resultado['candidato'],
            'votos' => $resultado['votos'],
            'percentagem' => round($percentagem, 2)
        ];
    }

    // Resposta de sucesso
    $response = [
        'success' => true,
        'percentagens' => $percentagens,
        'total_votos' => $totalVotos
    ];

    echo json_encode($response);
}
?>
