<?php
header('Content-Type: application/json');

if (!empty($_POST['nome'])) {
    echo json_encode(['ok'=>true,'msg' => 'Dados recebidos com sucesso!']);
} else {
    //http_response_code(400);
    echo json_encode(['erro'=>'input_01','msg' => 'Campo nome é obrigatório.']);
}

?>