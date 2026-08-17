<?php

$errors = [];
$ticket = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $idade = $_POST['idade'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $dia = $_POST['dia'] ?? '';
    $estudante = isset($_POST['estudante']);
    $quantidade = $_POST['quantidade'] ?? '';

    // Validação dos campos
    if ($nome === '') {
        $errors[] = 'Informe o nome.';
    }

    if ($idade === '') {
        $errors[] = 'Informe a idade.';
    }

    if ($tipo === '') {
        $errors[] = 'Escolha o tipo de ingresso.';
    }

    if ($dia === '') {
        $errors[] = 'Escolha o dia do evento.';
    }

    if ($quantidade === '') {
        $errors[] = 'Informe a quantidade de ingressos.';
    }

    // Converte os valores depois da validação
    if ($idade !== '') {
        $idade = (int) $idade;
    }

    if ($quantidade !== '') {
        $quantidade = (int) $quantidade;
    }

    // Validação dos valores
    if ($idade !== '' && $idade <= 0) {
        $errors[] = 'A idade deve ser maior que zero.';
    }

    if ($quantidade !== '' && $quantidade < 1) {
        $errors[] = 'A quantidade mínima é de 1 ingresso.';
    }

    // Tipos de ingresso válidos
    $tipos_validos = [
        'pista',
        'vip',
        'camarote'
    ];

    if (
        $tipo !== '' &&
        !in_array($tipo, $tipos_validos)
    ) {
        $errors[] = 'Tipo de ingresso inválido.';
    }

    // Dias válidos
    $dias_validos = [
        'dia1',
        'dia2'
    ];

    if (
        $dia !== '' &&
        !in_array($dia, $dias_validos)
    ) {
        $errors[] = 'Dia do evento inválido.';
    }


    // Continua somente se não houver erros
    if (empty($errors)) {

        // Menores de 16 anos não podem comprar
        if ($idade < 16) {

            $errors[] = 'Menores de 16 anos não podem comprar ingressos.';

        } else {

            // Preços dos ingressos
            $precos = [
                'pista' => 80,
                'vip' => 150,
                'camarote' => 250
            ];

            $preco_unitario = $precos[$tipo];


            // Calcula o desconto
            $desconto_percentual = 0;

            // Estudante recebe 20%, exceto no Camarote
            if ($estudante && $tipo !== 'camarote') {
                $desconto_percentual += 20;
            }

            // 3 ou mais ingressos recebem mais 10%
            if ($quantidade >= 3) {
                $desconto_percentual += 10;
            }

            // VIP possui limite de 15% de desconto
            if (
                $tipo === 'vip' &&
                $desconto_percentual > 15
            ) {
                $desconto_percentual = 15;
            }


            // Calcula os valores
            $subtotal = $preco_unitario * $quantidade;

            $valor_desconto =
                ($desconto_percentual / 100) * $subtotal;

            $total = $subtotal - $valor_desconto;


            // Guarda os dados do ingresso
            $ticket = [
                'nome' => $nome,
                'idade' => $idade,
                'tipo' => $tipo,
                'dia' => $dia,
                'quantidade' => $quantidade,
                'preco_unitario' => $preco_unitario,
                'subtotal' => $subtotal,
                'desconto_percentual' => $desconto_percentual,
                'valor_desconto' => $valor_desconto,
                'total' => $total
            ];
        }
    }
}


// Formata valores em reais
function moeda($valor)
{
    return 'R$ ' . number_format(
        $valor,
        2,
        ',',
        '.'
    );
}


// Converte o tipo do ingresso para um nome amigável
function tipoNome($tipo)
{
    $nomes = [
        'pista' => 'Pista',
        'vip' => 'VIP',
        'camarote' => 'Camarote'
    ];

    return $nomes[$tipo] ?? $tipo;
}


// Converte o código do dia para um nome amigável
function diaNome($dia)
{
    $dias = [
        'dia1' => 'Dia 1',
        'dia2' => 'Dia 2'
    ];

    return $dias[$dia] ?? $dia;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Compra de Ingressos</title>

    <link rel="stylesheet" href="css/global.css">

</head>

<body>

    <div class="wrap">

        <div class="card">

            <h2>Compra de Ingressos</h2>


            <form method="POST">

                <label>
                    Nome

                    <input
                        type="text"
                        name="nome"
                        required
                        value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
                    >
                </label>


                <div class="row">

                    <label>
                        Idade

                        <input
                            type="number"
                            name="idade"
                            min="1"
                            required
                            value="<?= htmlspecialchars($_POST['idade'] ?? '') ?>"
                        >
                    </label>


                    <label>
                        Quantidade

                        <input
                            type="number"
                            name="quantidade"
                            min="1"
                            required
                            value="<?= htmlspecialchars($_POST['quantidade'] ?? '1') ?>"
                        >
                    </label>

                </div>


                <label>
                    Tipo de ingresso

                    <select name="tipo" required>

                        <option value="">
                            Escolha o tipo
                        </option>

                        <option
                            value="pista"
                            <?= (($_POST['tipo'] ?? '') === 'pista') ? 'selected' : '' ?>
                        >
                            Pista - R$ 80,00
                        </option>

                        <option
                            value="vip"
                            <?= (($_POST['tipo'] ?? '') === 'vip') ? 'selected' : '' ?>
                        >
                            VIP - R$ 150,00
                        </option>

                        <option
                            value="camarote"
                            <?= (($_POST['tipo'] ?? '') === 'camarote') ? 'selected' : '' ?>
                        >
                            Camarote - R$ 250,00
                        </option>

                    </select>

                </label>


                <label>
                    Dia do evento

                    <select name="dia" required>

                        <option value="">
                            Escolha o dia
                        </option>

                        <option
                            value="dia1"
                            <?= (($_POST['dia'] ?? '') === 'dia1') ? 'selected' : '' ?>
                        >
                            Dia 1
                        </option>

                        <option
                            value="dia2"
                            <?= (($_POST['dia'] ?? '') === 'dia2') ? 'selected' : '' ?>
                        >
                            Dia 2
                        </option>

                    </select>

                </label>


                <label class="checkbox">

                    <input
                        type="checkbox"
                        name="estudante"
                        <?= isset($_POST['estudante']) ? 'checked' : '' ?>
                    >

                    Estudante
                    (20% de desconto, exceto Camarote)

                </label>


                <button type="submit">
                    Gerar ingresso
                </button>

            </form>


            <?php if (!empty($errors)): ?>

                <div class="errors">

                    <strong>
                        Não foi possível gerar o ingresso:
                    </strong>

                    <ul>

                        <?php foreach ($errors as $error): ?>

                            <li>
                                <?= htmlspecialchars($error) ?>
                            </li>

                        <?php endforeach; ?>

                    </ul>

                </div>

            <?php endif; ?>


            <?php if ($ticket): ?>

                <div class="ticket">

                    <div class="stub">

                        <div class="small">
                            Evento
                        </div>

                        <div class="event">
                            <?= tipoNome($ticket['tipo']) ?>
                        </div>

                        <div class="small">
                            Qtd:
                            <?= $ticket['quantidade'] ?>
                        </div>

                    </div>


                    <div class="main">

                        <div class="event">
                            INGRESSO
                        </div>


                        <div class="info">
                            <strong>Nome:</strong>
                            <?= htmlspecialchars($ticket['nome']) ?>
                        </div>


                        <div class="info">
                            <strong>Idade:</strong>
                            <?= $ticket['idade'] ?> anos
                        </div>


                        <div class="info">
                            <strong>Dia:</strong>
                            <?= diaNome($ticket['dia']) ?>
                        </div>


                        <div class="info">
                            <strong>Tipo:</strong>
                            <?= tipoNome($ticket['tipo']) ?>
                        </div>


                        <div class="info">
                            <strong>Preço unitário:</strong>
                            <?= moeda($ticket['preco_unitario']) ?>
                        </div>


                        <div class="info">
                            <strong>Subtotal:</strong>
                            <?= moeda($ticket['subtotal']) ?>
                        </div>


                        <div class="info">
                            <strong>Desconto:</strong>
                            <?= $ticket['desconto_percentual'] ?>%
                            (<?= moeda($ticket['valor_desconto']) ?>)
                        </div>


                        <div class="price">
                            Total a pagar:
                            <?= moeda($ticket['total']) ?>
                        </div>


                        <div class="observacoes">

                            <strong>Observações:</strong>

                            <?php

                            $observacoes = [];

                            if (
                                $estudante &&
                                $ticket['tipo'] === 'camarote'
                            ) {
                                $observacoes[] =
                                    'Estudante não possui desconto para Camarote.';
                            }

                            if (
                                $ticket['tipo'] === 'vip' &&
                                $ticket['desconto_percentual'] == 15
                            ) {
                                $observacoes[] =
                                    'Desconto limitado a 15% para VIP.';
                            }

                            if ($ticket['quantidade'] >= 3) {
                                $observacoes[] =
                                    'Desconto de 10% aplicado pela quantidade.';
                            }

                            if (!empty($observacoes)) {

                                echo htmlspecialchars(
                                    implode(' • ', $observacoes)
                                );

                            } else {

                                echo 'Nenhuma observação.';

                            }

                            ?>

                        </div>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</body>

</html>