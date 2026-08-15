<?php
if($_POST){
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    if($usuario == 'admin' && $senha == '1234'){
        echo "login realizado com sucesso 😀👍";
    }else{
        echo "Usuário ou senha inválidos 🤬";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="#" method="post">
        <label for="usuario">Usuário</label>
        <input type="text" name="usuario" id="usuario"><br><br>

        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha"><br><br>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>
