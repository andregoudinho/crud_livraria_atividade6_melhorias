<?php
include "../infra/conexao.php";
$id = $_GET["id"];
$sql = "DELETE FROM livros WHERE id=?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
header("Location: ../index.php");
?>