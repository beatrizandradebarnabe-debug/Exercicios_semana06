<?php

declare(strict_types=1);

// Variáveis
$valorVeiculo = '';
$valorEntrada = '';
$numeroParcelas = '';
$erro = '';

$valorFinanciado = null;
$totalJuros = null;
$valorParcela = null;

// Opções permitidas
$parcelasPermitidas = [12, 24, 36, 48, 60];

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $valorVeiculo = $_POST['valor_veiculo'] ?? '';
    $valorEntrada = $_POST['valor_entrada'] ?? '';
    $numeroParcelas = $_POST['numero_parcelas'] ?? '';

    // Converte os valores para números
    $veiculo = (float)$valorVeiculo;
    $entrada = (float)$valorEntrada;
    $parcelas = (int)$numeroParcelas;

    // Verifica se a entrada é pelo menos 20%
    if ($entrada < ($veiculo * 0.20)) {

        $erro = "A entrada deve ser de pelo menos 20% do valor do veículo.";

    // Verifica se o número de parcelas é permitido
    } elseif (!in_array($parcelas, $parcelasPermitidas)) {

        $erro = "Número de parcelas inválido.";

    // Verifica se os valores são válidos
    } elseif ($veiculo <= 0 || $entrada <= 0 || $entrada >= $veiculo) {

        $erro = "Informe valores válidos.";

    } else {

        // Calcula o valor que será financiado
        $valorFinanciado = $veiculo - $entrada;

        // Juros simples de 1,5% ao mês
        $taxaJuros = 0.015;

        // Total dos juros
        $totalJuros = $valorFinanciado * $taxaJuros * $parcelas;

        // Valor total com juros
        $totalFinanciamento = $valorFinanciado + $totalJuros;

        // Valor de cada parcela
        $valorParcela = $totalFinanciamento / $parcelas;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Financiamento</title>

    <style>

        .erro {
            color: red;
        }

        .resultado {
            border: 1px solid black;
            padding: 20px;
            width: 400px;
        }

    </style>
</head>

<body>

    <h1>Financiamento de Veículo</h1>

    <form method="POST">

        <label>Valor do veículo (R$):</label>

        <input
            type="number"
            name="valor_veiculo"
            step="0.01"
            value="<?= htmlspecialchars($valorVeiculo) ?>"
        >

        <br><br>

        <label>Valor da entrada (R$):</label>

        <input
            type="number"
            name="valor_entrada"
            step="0.01"
            value="<?= htmlspecialchars($valorEntrada) ?>"
        >

        <br><br>

        <label>Número de parcelas:</label>

        <select name="numero_parcelas">

            <option value="">Selecione</option>

            <?php foreach ($parcelasPermitidas as $opcao): ?>

                <option
                    value="<?= $opcao ?>"
                    <?= $numeroParcelas == $opcao ? 'selected' : '' ?>
                >
                    <?= $opcao ?> vezes
                </option>

            <?php endforeach; ?>

        </select>

        <br><br>

        <button type="submit">Calcular</button>

    </form>


    <?php if ($erro !== ''): ?>

        <p class="erro">
            <?= htmlspecialchars($erro) ?>
        </p>

    <?php endif; ?>


    <?php if ($valorFinanciado !== null): ?>

        <div class="resultado">

            <h2>Memória de Cálculo</h2>

            <p>
                Valor do veículo:
                R$ <?= number_format($veiculo, 2, ',', '.') ?>
            </p>

            <p>
                Valor da entrada:
                R$ <?= number_format($entrada, 2, ',', '.') ?>
            </p>

            <p>
                Valor financiado:
                R$ <?= number_format($valorFinanciado, 2, ',', '.') ?>
            </p>

            <p>
                Total de juros:
                R$ <?= number_format($totalJuros, 2, ',', '.') ?>
            </p>

            <p>
                Número de parcelas:
                <?= $parcelas  ?>
            </p>

            <p>
                Valor de cada parcela:
                R$ <?= number_format($valorParcela, 2, ',', '.') ?>
            </p>

        </div>

    <?php endif; ?>

</body>

</html>