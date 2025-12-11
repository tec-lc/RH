<?php

class MontaArray
{
    private array $data = [];

    // Junta os arrays (mantém igual ao seu formato)
    public function add(array $arr)
    {
        $this->data = array_merge_recursive($this->data, $arr);
    }

    // Salva no formato:  php $val=[ ... ];
    public function salva(string $arquivo)
    {
        // Garante que a pasta exista
        $dir = dirname($arquivo);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // Converte array para sintaxe com colchetes
        $export = $this->exportBrackets($this->data);

        $conteudo = "<?php \$val = " . $export . "; ?>";

        file_put_contents($arquivo, $conteudo);
    }

    // Converte array para formato com []
    private function exportBrackets($var)
    {
        if (!is_array($var)) {
            return var_export($var, true);
        }

        $str = "[\n";
        foreach ($var as $key => $value) {
            $str .= $this->formatKey($key) . " => " . $this->exportBrackets($value) . ",\n\n";
        }
        $str .= "]";

        return $str;
    }

    // Formata a chave corretamente
    private function formatKey($key)
    {
        if (is_numeric($key)) {
            return $key;
        }
        return "'$key'";
    }
}

?>

