<?php
session_start();
include("conexao.php");

if (isset($_POST['entrar'])){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Busca só pelo email
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0){
        $usuario = mysqli_fetch_assoc($resultado);

        // Verifica a senha cifrada
        if (password_verify($senha, $usuario['senha'])) {

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['tipo'] = $usuario['tipo'];

            header("Location: index.php");
            exit();

        } else {
            $erro = "Email ou senha incorretos.";
        }
    } else {
        $erro = "Email ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php if (isset($erro)):?>
        <p style="color:red"><?=$erro?></p>
    <?php endif;?>

    <form method="POST" autocomplete="off">
        <label>Email:</label><br>
        <input type="text" name="email" required> <br><br>

        <label>Senha:</label>
        <input type="password" name="senha" required><br><br>

        <button type="submit" name="entrar">Entrar</button>
    
    </form>

    <br>
    <a href="registar.php">Não tens conta? Registra-se</a>
</body>
</html>