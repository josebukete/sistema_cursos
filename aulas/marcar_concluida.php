<?php
include("../config/verificar_sessao.php");
include("../config/conexao.php");
$aula_id = $_POST['aula_id'];
$curso_id = $_POST['curso_id'];

// Verificar se já existe registo de progresso para esta aula
$verificar = "SELECT id FROM progresso_aulas 
              WHERE usuario_id=$usuario_id AND aula_id=$aula_id";
$resultado = mysqli_query($conexao, $verificar);

if (mysqli_num_rows($resultado) > 0) {
    // Já existe, ent atualiza
    $sql = "UPDATE progresso_aulas 
            SET concluida=1, data_conclusao=NOW()
            WHERE usuario_id=$usuario_id AND aula_id=$aula_id";
} else {
    // N existe 
    $sql = "INSERT INTO progresso_aulas (usuario_id, aula_id, concluida, data_conclusao)
            VALUES ($usuario_id, $aula_id, 1, NOW())";
}

mysqli_query($conexao, $sql);


header("Location: ver_aulas.php?curso_id=$curso_id");
exit();
?>