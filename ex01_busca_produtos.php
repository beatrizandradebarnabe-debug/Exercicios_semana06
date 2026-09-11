<?php

declare(strict_types=1);

// Array com os produtos
$produtos = [
    ["nome" => "Notebook", "categoria" => "Informática", "preco" => 3500.00],
    ["nome" => "Mouse", "categoria" => "Informática", "preco" => 80.00],
    ["nome" => "Teclado", "categoria" => "Informática", "preco" => 150.00],
    ["nome" => "Celular", "categoria" => "Eletrônicos", "preco" => 1800.00],
    ["nome" => "Fone de Ouvido", "categoria" => "Eletrônicos", "preco" => 120.00],
    ["nome" => "Monitor", "categoria" => "Informática", "preco" => 900.00]
];

// Pegando os valores enviados pelo formulário
$nomeBusca = $_GET['nome'] ?? '';
$precoMaximo = $_GET['preco_maximo'] ?? '';

// Começamos com todos os produtos
$produtosFiltrados = $produtos;

// Se algum filtro foi preenchido
if ($nomeBusca !== '' || $precoMaximo !== '') {

    $produtosFiltrados = array_filter($produtos, function ($produto) use ($nomeBusca, $precoMaximo) {

        // Verifica se o nome digitado aparece no nome do produto
        $nomeCorresponde = true;

        if ($nomeBusca !== '') {
            $nomeCorresponde = stripos($produto['nome'], $nomeBusca) !== false;
        }

        // Verifica o preço máximo
        $precoCorresponde = true;

        if ($precoMaximo !== '') {
            $precoCorresponde = $produto['preco'] <= (float) $precoMaximo;
        }

        // O produto precisa atender aos dois filtros
        return $nomeCorresponde && $precoCorresponde;
    });
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Busca de Produtos</title>
</head>

<body>

    <h1>Buscador de Produtos</h1>

    <form method="GET">

        <label>Nome do produto:</label>
        <input
            type="text"
            name="nome"
            value="<?= htmlspecialchars($nomeBusca) ?>"
        >

        <br><br>

        <label>Preço máximo:</label>
        <input
            type="number"
            name="preco_maximo"
            step="0.01"
            value="<?= htmlspecialchars($precoMaximo) ?>"
        >

        <br><br>

        <button type="submit">Buscar</button>

    </form>

    <hr>

    <h2>Produtos encontrados</h2>

    <?php if (count($produtosFiltrados) > 0): ?>

        <?php foreach ($produtosFiltrados as $produto): ?>

            <p>
                <strong><?= htmlspecialchars($produto['nome']) ?></strong><br>
                Categoria: <?= htmlspecialchars($produto['categoria']) ?><br>
                Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
            </p>

            <hr>

        <?php endforeach; ?>

    <?php else: ?>

        <p>Nenhum produto encontrado.</p>

    <?php endif; ?>

</body>

</html>