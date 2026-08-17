<?php

$resultado = null;
$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $produto = trim($_POST['produto'] ?? '');
    $nome = trim($_POST['nome'] ?? '');

    $valor = $_POST['valor'] ?? '';
    $entrada = $_POST['entrada'] ?? '';
    $parcelas = $_POST['parcelas'] ?? '';

    // Validação dos campos
    if ($produto === '') {
        $produto = 'Produto';
    }

    if ($nome === '') {
        $erros[] = 'Preencha o nome do cliente.';
    }

    if ($valor === '') {
        $erros[] = 'Informe o valor do produto.';
    }

    if ($entrada === '') {
        $erros[] = 'Informe o valor da entrada.';
    }

    if ($parcelas === '') {
        $erros[] = 'Informe a quantidade de parcelas.';
    }

    // Converte os valores somente depois da validação
    if ($valor !== '') {
        $valor = (float) str_replace(',', '.', $valor);
    }

    if ($entrada !== '') {
        $entrada = (float) str_replace(',', '.', $entrada);
    }

    if ($parcelas !== '') {
        $parcelas = (int) $parcelas;
    }

    // Verifica os valores numéricos
    if ($valor !== '' && $valor <= 0) {
        $erros[] = 'O valor do produto deve ser maior que zero.';
    }

    if ($entrada !== '' && $entrada < 0) {
        $erros[] = 'A entrada não pode ser negativa.';
    }

    if ($parcelas !== '' && $parcelas <= 0) {
        $erros[] = 'A quantidade de parcelas deve ser maior que zero.';
    }

    // Continua apenas se não houver erros
    if (empty($erros)) {

        // A entrada não pode ser maior que o valor do produto
        if ($entrada > $valor) {

            $erros[] = 'A entrada não pode ser maior que o valor do produto.';

        } else {

            // Calcula a porcentagem da entrada
            $entrada_percentual = ($entrada / $valor) * 100;

            // Calcula o valor que será financiado
            $valor_financiado = $valor - $entrada;

            // Regra mínima de entrada
            if ($entrada_percentual < 20) {
                $erros[] = 'Entrada insuficiente: mínimo de 20% do valor do produto.';
            }

            // Regras de acordo com a quantidade de parcelas
            if ($parcelas <= 12) {

                // Até 12 parcelas: entrada mínima de 20%

            } elseif ($parcelas <= 24) {

                // De 13 até 24 parcelas
                if ($entrada_percentual < 30) {
                    $erros[] = 'Parcelamento de 13 a 24 vezes exige entrada mínima de 30%.';
                }

            } else {

                // Acima de 24 parcelas
                if ($entrada_percentual < 40) {
                    $erros[] = 'Parcelamento acima de 24 vezes exige entrada mínima de 40%.';
                }
            }

            // Valor mínimo financiado
            if ($valor_financiado < 500) {
                $erros[] = 'O valor financiado deve ser de pelo menos R$ 500,00.';
            }

            // Se não houver nenhum erro, o financiamento é aprovado
            if (empty($erros)) {

                $resultado = [
                    'produto' => $produto,
                    'nome' => $nome,
                    'valor' => $valor,
                    'entrada' => $entrada,
                    'valor_financiado' => $valor_financiado,
                    'parcelas' => $parcelas
                ];
            }
        }
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

    <title>Simulador de Financiamento</title>

    <link rel="stylesheet" href="css/global.css">

</head>

<body>

    <div class="card">

        <h2>Simulador de Financiamento</h2>

        <form method="POST">

            <label>
                Produto

                <input
                    type="text"
                    name="produto"
                    value="<?= htmlspecialchars($_POST['produto'] ?? 'Notebook') ?>"
                >
            </label>

            <label>
                Nome do cliente

                <input
                    type="text"
                    name="nome"
                    required
                    value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
                >
            </label>

            <label>
                Valor do produto

                <input
                    type="number"
                    name="valor"
                    step="0.01"
                    min="0"
                    required
                    value="<?= htmlspecialchars($_POST['valor'] ?? '') ?>"
                >
            </label>

            <label>
                Entrada

                <input
                    type="number"
                    name="entrada"
                    step="0.01"
                    min="0"
                    required
                    value="<?= htmlspecialchars($_POST['entrada'] ?? '') ?>"
                >
            </label>

            <label>
                Quantidade de parcelas

                <input
                    type="number"
                    name="parcelas"
                    min="1"
                    required
                    value="<?= htmlspecialchars($_POST['parcelas'] ?? '') ?>"
                >
            </label>

            <button type="submit">
                Verificar financiamento
            </button>

        </form>


        <?php if (!empty($erros)): ?>

            <div class="erro">

                <strong>
                    Não foi possível aprovar o financiamento:
                </strong>

                <ul>

                    <?php foreach ($erros as $erro): ?>

                        <li>
                            <?= htmlspecialchars($erro) ?>
                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>


        <?php elseif ($resultado): ?>

            <div class="resultado">

                <div>
                    <strong>Cliente:</strong>
                    <?= htmlspecialchars($resultado['nome']) ?>
                </div>

                <div>
                    <strong>Produto:</strong>
                    <?= htmlspecialchars($resultado['produto']) ?>
                </div>

                <div>
                    <strong>Valor:</strong>
                    <?= moeda($resultado['valor']) ?>
                </div>

                <div>
                    <strong>Entrada:</strong>
                    <?= moeda($resultado['entrada']) ?>
                </div>

                <div>
                    <strong>Valor financiado:</strong>
                    <?= moeda($resultado['valor_financiado']) ?>
                </div>

                <div>
                    <strong>Parcelas:</strong>
                    <?= $resultado['parcelas'] ?>
                </div>

                <div class="aprovado">
                    Situação: FINANCIAMENTO APROVADO
                </div>

            </div>

        <?php endif; ?>

    </div>

</body>

</html>