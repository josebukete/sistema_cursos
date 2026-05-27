<?php
session_start();
include("../config/conexao.php");

if (isset($_POST['registar'])){

    $nome = $_POST['nome'];
    $email = $_POST ['email'];
    $senha = $_POST ['senha'];
    $tipo = $_POST ['tipo'];

    $senha_cifrada = password_hash($senha, PASSWORD_DEFAULT);

    //esse email será q existe?
    $verificar = "SELECT id FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexao, $verificar);

    if (mysqli_num_rows($resultado) >0){
        $erro = "Este email já está registado.";
    } else {
        $sql = "INSERT INTO usuarios (nome, email, senha,tipo) VALUES ('$nome', '$email', '$senha_cifrada', '$tipo')";
        mysqli_query($conexao, $sql);

        $erro = "Conta criada com Sucesso!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registar</title>
</head>
<body>
    <h2>Criar Conta</h2>

    <?php if (isset($erro)):?>
        <p><?= $erro?></p>
    <?php endif;?>

    <form method="POST" autocomplete="off">

        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Email:</label><br>
        <input type="text" name="email" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>

        <label>Tipo de Conta:</label><br>
        <select name="tipo">
            <option value="aluno">Aluno</option>
            <option value="formador">Formador</option>
        </select><br><br>

        <button type="submit" name="registar">Criar Conta</button>

    </form>

    <br>
    <a href="login.php">Já tens conta? Entra aqui</a>
    
</body>
</html>