<?php

include('navbar.php');

function isValidBrackets($str) {
    $stack = [];
    
    $mapaColchetes = [
        ')' => '(',
        '}' => '{',
        ']' => '['
    ];
    
    for ($i = 0; $i < strlen($str); $i++) {
        $char = $str[$i];

        if (array_key_exists($char, $mapaColchetes)) {
            $topElement = empty($stack) ? '#' : array_pop($stack);

            if ($topElement !== $mapaColchetes[$char]) {
                return false;
            }
        } else {
            array_push($stack, $char);
        }
    }

    return empty($stack);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validação de Colchetes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            &nbsp; Voltar
        </a>

        <h2 class="mt-4">Verificação de Colchetes</h2>
        <form method="post">
            <div class="form-group">
                <label for="bracketString">Digite a sequência:</label>
                <input type="text" class="form-control" id="bracketString" name="bracketString" required>
            </div>
            <button type="submit" class="btn btn-primary">
                Verificar
            </button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $inputString = $_POST['bracketString'];
            $isValid = isValidBrackets($inputString) ? "Válido" : "Não é válido.";
            echo "<div class='mt-3 alert alert-info'>A sequência <strong>'$inputString'</strong> é <strong>$isValid</strong>.</div>";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
