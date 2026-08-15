<?php
if($_POST){
$idade= $_POST['idade'];
if($idade>=18){
    echo"Maior de idade😀👍";
}else{
    echo"Menor de idade🤨👀";
}
}
?> 

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IF🤷‍♂️</title>
</head>
<body>
    <form action="#" method="post">
        <label for="">Digite a idade</label>
        <input type="number" name="idade">
        <button type="submit">Verificar</button>
    </form>
</body>
</html>