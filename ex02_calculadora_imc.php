<?php

declare(strict_types=1);

// Função para calcular o IMC
function calcularIMC(float $peso, float $altura): float
{
    return $peso / ($altura * $altura);
}

// Função para classificar o resultado
function classificarIMC(float $imc): string
{
    if ($imc < 18.5) {
        return "Abaixo do peso";
    }

    if ($imc < 25) {
        return "Normal";
    }

    if ($imc < 30) {
        return "Sobrepeso";
    }

    return "Obesidade";
}

// Variáveis
$nome = '';
$peso = '';
$altura = '';
$erro = '';
$imc = null;
$classificacao = '';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $peso = $_POST['peso'] ?? '';
    $altura = $_POST['altura'] ?? '';

    // Validação do peso
    if (!is_numeric($peso) || (float)$peso < 20 || (float)$peso > 300) {
        $erro = "O peso deve estar entre 20 e 300 kg.";
    }

    // Validação da altura
    elseif (!is_numeric($altura) || (float)$altura < 0.5 || (float)$altura > 2.5) {
        $erro = "A altura deve estar entre 0.5 e 2.5 metros.";
    }

    // Se não houver erro, calcula
    else {

        $peso = (float)$peso;
        $altura = (float)$altura;

        $imc = calcularIMC($peso, $altura);
        $classificacao = classificarIMC($imc);
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Calculadora de IMC</title>

    <style>

        .normal {
            background-color: green;
            color: white;
            padding: 15px;
        }

        .sobrepeso {
            background-color: yellow;
            color: black;
            padding: 15px;
        }

        .obesidade {
            background-color: red;
            color: white;
            padding: 15px;
        }

        .erro {
            color: red;
        }

    </style>
</head>

<body>

    <h1>Calculadora de IMC</h1>

    <form method="POST">

        <label>Nome:</label>
        <input
            type="text"
            name="nome"
            value="<?= htmlspecialchars($nome) ?>"
        >

        <br><br>

        <label>Peso (kg):</label>
        <input
            type="number"
            name="peso"
            step="0.01"
            value="<?= htmlspecialchars((string)$peso) ?>"
        >

        <br><br>

        <label>Altura (m):</label>
        <input
            type="number"
            name="altura"
            step="0.01"
            value="<?= htmlspecialchars((string)$altura) ?>"
        >

        <br><br>

        <button type="submit">Calcular</button>

    </form>

    <?php if ($erro !== ''): ?>

        <p class="erro">
            <?= htmlspecialchars($erro) ?>
        </p>

    <?php endif; ?>


    <?php if ($imc !== null): ?>

        <?php
        // Define a classe de acordo com o resultado
        $classe = '';

        if ($classificacao === 'Normal') {
            $classe = 'normal';
        } elseif ($classificacao === 'Sobrepeso') {
            $classe = 'sobrepeso';
        } elseif ($classificacao === 'Obesidade') {
            $classe = 'obesidade';
        }
        ?>

        <div class="<?= $classe ?>">

            <h2>Resultado</h2>

            <p>
                Nome: <?= htmlspecialchars($nome) ?>
            </p>

            <p>
                IMC: <?= number_format($imc, 2, ',', '.') ?>
            </p>

            <p>
                Classificação: <?= htmlspecialchars($classificacao) ?>
            </p>

        </div>

    <?php endif; ?>

</body>

</html>