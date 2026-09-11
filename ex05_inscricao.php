<?php

declare(strict_types=1);

// Variáveis
$nome = '';
$idade = '';
$curso = '';
$aceite = false;

// Lista de cursos permitidos
$cursosPermitidos = [
    "Desenvolvimento de Sistemas",
    "Mecatrônica",
    "Redes"
];

// Array para guardar os erros
$erros = [];

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome_candidato'] ?? '');
    $idade = $_POST['idade'] ?? '';
    $curso = $_POST['curso_desejado'] ?? '';

    // Verifica se o checkbox foi marcado
    $aceite = isset($_POST['aceite_termos']);

    // Validação do nome
    if (strlen($nome) < 5) {
        $erros['nome'] = "O nome deve ter pelo menos 5 caracteres.";
    }

    // Validação da idade
    if ($idade === '' || !is_numeric($idade) || (int)$idade < 16) {
        $erros['idade'] = "A idade deve ser maior ou igual a 16 anos.";
    }

    // Validação do curso
    if (
        $curso === '' ||
        !in_array($curso, $cursosPermitidos)
    ) {
        $erros['curso'] = "Selecione um curso válido.";
    }

    // Validação dos termos
    if (!$aceite) {
        $erros['termos'] = "Você deve aceitar os termos.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Inscrição SENAI</title>

    <style>

        .erro {
            color: red;
        }

        .sucesso {
            color: green;
        }

    </style>
</head>

<body>

    <h1>Inscrição - Cursos Técnicos SENAI</h1>

    <form method="POST">

        <!-- Nome -->

        <label>Nome do candidato:</label>

        <input
            type="text"
            name="nome_candidato"
            value="<?= htmlspecialchars($nome) ?>"
        >

        <?php if (isset($erros['nome'])): ?>

            <p class="erro">
                <?= htmlspecialchars($erros['nome']) ?>
            </p>

        <?php endif; ?>


        <!-- Idade -->

        <label>Idade:</label>

        <input
            type="number"
            name="idade"
            value="<?= htmlspecialchars((string)$idade) ?>"
        >

        <?php if (isset($erros['idade'])): ?>

            <p class="erro">
                <?= htmlspecialchars($erros['idade']) ?>
            </p>

        <?php endif; ?>


        <br><br>


        <!-- Curso -->

        <label>Curso desejado:</label>

        <select name="curso_desejado">

            <option value="">Selecione um curso</option>

            <?php foreach ($cursosPermitidos as $cursoOpcao): ?>

                <option
                    value="<?= htmlspecialchars($cursoOpcao) ?>"
                    <?= $curso === $cursoOpcao ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars($cursoOpcao) ?>
                </option>

            <?php endforeach; ?>

        </select>

        <?php if (isset($erros['curso'])): ?>

            <p class="erro">
                <?= htmlspecialchars($erros['curso']) ?>
            </p>

        <?php endif; ?>


        <br><br>


        <!-- Termos -->

        <label>

            <input
                type="checkbox"
                name="aceite_termos"
                <?= $aceite ? 'checked' : '' ?>
            >

            Aceito os termos da inscrição.

        </label>

        <?php if (isset($erros['termos'])): ?>

            <p class="erro">
                <?= htmlspecialchars($erros['termos']) ?>
            </p>

        <?php endif; ?>


        <br><br>

        <button type="submit">
            Realizar inscrição
        </button>

    </form>


    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($erros)): ?>

        <h2 class="sucesso">
            Inscrição realizada com sucesso!
        </h2>

        <p>
            Candidato:
            <?= htmlspecialchars($nome) ?>
        </p>

        <p>
            Idade:
            <?= htmlspecialchars((string)$idade) ?>
        </p>

        <p>
            Curso:
            <?= htmlspecialchars($curso) ?>
        </p>

    <?php endif; ?>

</body>

</html>