<?php 


/*
function executa_conversao($entradaXlsm, $saidaPhp) {
    // Caminhos fixos
    $venvPython = '/var/www/html/rh/backend/venv/bin/python';
    $script     = '/var/www/html/rh/backend/converte.py';

    // Monta o comando com segurança
    $cmd = escapeshellarg($venvPython) . ' ' .
           escapeshellarg($script) . ' ' .
           escapeshellarg($entradaXlsm) . ' ' .
           escapeshellarg($saidaPhp) . ' 2>&1';

    $saida = [];
    $ret   = 0;

    exec($cmd, $saida, $ret);

    return [
        'cmd'    => $cmd,
        'ret'    => $ret,
        'saida'  => $saida,
    ];
}


$resultado = executa_conversao(
        '/var/www/html/rh/uploads/planilha.xlsm',
        '/var/www/html/rh/uploads/temp.php'
    );

    if ($resultado['ret'] === 0) {
        echo "Conversão OK!<br>";
    } else {
        echo "Erro ao executar script Python (código {$resultado['ret']})<br>";
    }

    echo "<pre>";
    print_r($resultado['saida']);
    echo "</pre>";
*/
//======================================================================================
require 'class-php/func.indice.php';
require 'class-php/class.MontaArray.php';




// Mostra erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Pasta destino
$diretorioDestino = 'upload/';
$nome_plan = "planilha.xlsm";   // nome final no servidor

// Garante que a pasta exista
if (!is_dir($diretorioDestino)) {
    if (!mkdir($diretorioDestino, 0775, true)) {
        die("❌ Não consegui criar a pasta uploads.");
    }
}

// Verifica se a pasta é gravável
if (!is_writable($diretorioDestino)) {
    die("❌ Pasta não é gravável.");
}


$array=new MontaArray();


// --- FUNÇÃO CORRIGIDA ---
function monta_php($planilha, $tipo,$array)
{
    // Converte caminhos corretamente
    $caminhoPlanilha = "/var/www/html/rh/upload/" . $planilha;
    $caminhoTempPy   = "/var/www/html/rh/upload/tempPy.php";
    $val=[];
    //$val2=[];

    // Executa Python processando o arquivo correto
    $resultado = executa_conversao($caminhoPlanilha, $caminhoTempPy);

    if ($resultado['ret'] === 0) {
        echo "Conversão OK!<br>";
        require 'planilhas/tempPy.php';
        require 'planilhas/temp.php';

        $array->add($val2,$val);
        



        // Lê arquivo gerado pelo Python
        /*$arquivoTempPy = 'planilhas/tempPy.php';
        if (!file_exists($arquivoTempPy)) {
            echo "❌ tempPy.php não encontrado!<br>";
            return;
        }

        $conteudo = file_get_contents($arquivoTempPy);

        // Salva arquivo PHP final
        file_put_contents(
            'planilhas/temp.php',
             $conteudo. "\n"."\$val= \$val2 + @\$val; \$tipo=\"$tipo\";?>\n",
            FILE_APPEND
        );*/

    } else {
        echo "❌ Erro na conversão (código {$resultado['ret']})<br>";
    }
}






// -------------------------------------------------------------
// PROCESSAMENTO DO UPLOAD
// -------------------------------------------------------------

if (!isset($_FILES['arquivo'])) {
    die("❌ Nenhum arquivo enviado.");
}

$tipo = isset($_GET['tipo']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['tipo']) : 'VA';
$arquivos = $_FILES['arquivo'];

// Upload único ou múltiplo
if (!is_array($arquivos['name'])) {

    if ($arquivos['error'] !== UPLOAD_ERR_OK) {
        die("❌ Erro no upload: {$arquivos['error']}");
    }

    $tmpName = $arquivos['tmp_name'];

    $destino = $diretorioDestino . $nome_plan;

    if (move_uploaded_file($tmpName, $destino)) {

        // Agora SIM processa a planilha
        monta_php($nome_plan, $tipo);

        echo "✅ Upload concluído: {$arquivos['name']}<br>";

    } else {
        echo "❌ Erro ao mover upload.<br>";
    }

} else {

    // Upload múltiplo
    $total = count($arquivos['name']);

    for ($i = 0; $i < $total; $i++) {

        if ($arquivos['error'][$i] !== UPLOAD_ERR_OK) {
            echo "❌ Erro no arquivo $i<br>";
            continue;
        }

        $tmpName = $arquivos['tmp_name'][$i];
        $destino = $diretorioDestino . $nome_plan;

        if (move_uploaded_file($tmpName, $destino)) {

            monta_php($nome_plan, $tipo,$array);

            echo "✅ Arquivo $i enviado e processado.<br>";

        } else {
            echo "❌ Falha ao salvar arquivo $i<br>";
        }
    }
}


$array->salva('planilhas/temp.php');
?>
