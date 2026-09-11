<?php

declare(strict_types=1);

// Variáveis
$email = '';
$erro = '';
$mensagem = '';
$loginCorreto = false;

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Pega o email e a senha
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    // Validação do email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $erro = "Digite um e-mail válido.";

    // Validação da senha
    } elseif (strlen($senha) < 6) {

        $erro = "A senha deve ter no mínimo 6 caracteres.";

    } else {

        // Dados fictícios para comparação
        $emailCorreto = "admin@senai.br";
        $senhaCorreta = "senhaSegura123";

        // Verifica se email e senha estão corretos
        if ($email === $emailCorreto && $senha === $senhaCorreta) {

            $loginCorreto = true;

        } else {

            $erro = "Credenciais inválidas";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login Seguro</title>

    <style>

        .erro {
            color: red;
        }

        .card {
            border: 1px solid black;
            padding: 20px;
            width: 300px;
        }

    </style>
</head>

<body>

    <h1>Login</h1>

    <?php if (!$loginCorreto): ?>

        <form method="POST">

            <label>E-mail:</label>
            <input
                type="email"
                name="email"
                value="<?= htmlspecialchars($email) ?>"
            >

            <br><br>

            <label>Senha:</label>
            <input
                type="password"
                name="senha"
            >

            <br><br>

            <button type="submit">Entrar</button>

        </form>

    <?php endif; ?>


    <?php if ($erro !== ''): ?>

        <p class="erro">
            <?= htmlspecialchars($erro) ?>
        </p>

    <?php endif; ?>


    <?php if ($loginCorreto): ?>

        <div class="card">

            <h2>Bem-vindo!</h2>

            <p>
                Login realizado com sucesso.
            </p>

            <p>
                Usuário: <?= htmlspecialchars($email) ?>
            </p>

        </div>

    <?php endif; ?>

</body>

</html>