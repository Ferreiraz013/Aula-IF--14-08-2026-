<?php
if($_POST){
    $saldo = $_POST['saldo'];
    $saque = $_POST['saque'];

    if($saque > $saldo){
        echo "Saldo insuficiente 😭😭😭";
    }elseif($saque <= $saldo && $saque % 10 == 0){
        echo "Saque realizado com sucesso 😀👍";
    }else{
        echo "Valor inválido para saque. O valor deve ser múltiplo de 10 🤨👀";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caixa Eletrônico</title>
</head>
<body>
    <form action="#" method="post">
        <label for="saldo">Saldo disponível</label>
        <input type="number" name="saldo" id="saldo"><br><br>

        <label for="saque">Valor do saque</label>
        <input type="number" name="saque" id="saque"><br><br>

        <button type="submit">Sacar</button>
    </form>
</body>
</html>
