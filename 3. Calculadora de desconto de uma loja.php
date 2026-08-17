<?php

$resultado = null;
$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $produto = trim($_POST['produto'] ?? '');
    $valor = $_POST['valor'] ?? '';
    $idade = $_POST['idade'] ?? '';
    $vip = isset($_POST['vip']);
    $pagamento = $_POST['pagamento'] ?? '';

    // Validação dos campos
    if ($produto === '') {
        $erros[] = 'Informe o nome do produto.';
    }

    if ($valor === '') {
        $erros[] = 'Informe o valor do produto.';
    }

    if ($idade === '') {
        $erros[] = 'Informe a idade do cliente.';
    }

    if ($pagamento === '') {
        $erros[] = 'Selecione uma forma de pagamento.';
    }

    // Converte os valores depois da validação
    if ($valor !== '') {
        $valor = (float) str_replace(',', '.', $valor);
    }

    if ($idade !== '') {
        $idade = (int) $idade;
    }

    // Validação dos valores numéricos
    if ($valor !== '' && $valor <= 0) {
        $erros[] = 'O valor deve ser maior que zero.';
    }

    if ($idade !== '' && $idade < 0) {
        $erros[] = 'A idade não pode ser negativa.';
    }

    // Verifica se a forma de pagamento é válida
    $pagamentos_validos = ['pix', 'cartao', 'boleto'];

    if (
        $pagamento !== '' &&
        !in_array($pagamento, $pagamentos_validos)
    ) {
        $erros[] = 'Forma de pagamento inválida.';
    }

    // Se não houver erros, calcula o desconto
    if (empty($erros)) {

        $desconto = 0;

        // Produto acima de R$ 500
        if ($valor > 500) {
            $desconto += 10;
        }

        // Cliente VIP
        if ($vip) {
            $desconto += 5;
        }

        // Cliente com mais de 60 anos
        if ($idade > 60) {
            $desconto += 5;
        }

        // Pagamento via Pix
        if ($pagamento === 'pix') {
            $desconto += 3;
        }

        // Limite máximo de desconto
        if ($desconto > 20) {
            $desconto = 20;
        }

        // Calcula o valor do desconto
        $valor_desconto = ($desconto / 100) * $valor;

        // Calcula o valor final
        $valor_final = $valor - $valor_desconto;

        $resultado = [
            'produto' => $produto,
            'valor' => $valor,
            'idade' => $idade,
            'desconto_pct' => $desconto,
            'desconto_val' => $valor_desconto,
            'valor_final' => $valor_final
        ];
    }
}


// Função para formatar valores em reais
function moeda($valor)
{
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Calculadora de Desconto</title>

    <link rel="stylesheet" href="css/global.css">

</head>

<body>

    <div class="box">

        <h2>Calculadora de Desconto</h2>

        <form method="POST">

            <label>
                Produto

                <input
                    type="text"
                    name="produto"
                    required
                    value="<?= htmlspecialchars($_POST['produto'] ?? '') ?>"
                >
            </label>


            <label>
                Valor

                <input
                    type="number"
                    name="valor"
                    step="0.01"
                    min="0"
                    required
                    value="<?= htmlspecialchars($_POST['valor'] ?? '') ?>"
                >
            </label>


            <div class="inline">

                <label>
                    Idade

                    <input
                        type="number"
                        name="idade"
                        min="0"
                        required
                        value="<?= htmlspecialchars($_POST['idade'] ?? '') ?>"
                    >
                </label>


                <label class="checkbox">

                    <input
                        type="checkbox"
                        name="vip"
                        <?= isset($_POST['vip']) ? 'checked' : '' ?>
                    >

                    Cliente VIP?

                </label>

            </div>


            <label>
                Forma de pagamento

                <select name="pagamento" required>

                    <option value="">
                        Selecione
                    </option>

                    <option
                        value="pix"
                        <?= (($_POST['pagamento'] ?? '') === 'pix') ? 'selected' : '' ?>
                    >
                        Pix
                    </option>

                    <option
                        value="cartao"
                        <?= (($_POST['pagamento'] ?? '') === 'cartao') ? 'selected' : '' ?>
                    >
                        Cartão
                    </option>

                    <option
                        value="boleto"
                        <?= (($_POST['pagamento'] ?? '') === 'boleto') ? 'selected' : '' ?>
                    >
                        Boleto
                    </option>

                </select>

            </label>


            <button type="submit">
                Calcular desconto
            </button>

        </form>


        <?php if (!empty($erros)): ?>

            <div class="erro">

                <strong>
                    Não foi possível calcular o desconto:
                </strong>

                <ul>

                    <?php foreach ($erros as $erro): ?>

                        <li>
                            <?= htmlspecialchars($erro) ?>
                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>

        <?php endif; ?>


        <?php if ($resultado): ?>

            <div class="resultado">

                <div>
                    <strong>Produto:</strong>
                    <?= htmlspecialchars($resultado['produto']) ?>
                </div>

                <div>
                    <strong>Valor original:</strong>
                    <?= moeda($resultado['valor']) ?>
                </div>

                <div>
                    <strong>Desconto:</strong>
                    <?= $resultado['desconto_pct'] ?>%
                    (<?= moeda($resultado['desconto_val']) ?>)
                </div>

                <div class="final">

                    <strong>
                        Valor final:
                    </strong>

                    <?= moeda($resultado['valor_final']) ?>

                </div>


                <div class="mensagem">

                    <?php if ($resultado['desconto_pct'] == 0): ?>

                        Sem desconto aplicado.

                    <?php else: ?>

                        Parabéns! Você recebeu
                        <?= $resultado['desconto_pct'] ?>%
                        de desconto!

                    <?php endif; ?>

                </div>

            </div>

        <?php endif; ?>

    </div>

</body>

</html>