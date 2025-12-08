<?php


class BancoTxt {
    private $arquivo;
    private $charset;
    private $xml;

    public function __construct($arquivo, $charset = 'utf8') {
      $this->arquivo = $arquivo;
      $this->charset = $charset;

      if (file_exists($arquivo)) {
          $this->xml = simplexml_load_file($arquivo);
      } else {
          $this->xml = false; // Sinaliza que o arquivo não existe
      }
    }


    public function newBanco($estrutura) {
        foreach ($estrutura as $tabela => $campos) {
            $tbl = $this->xml->addChild($tabela);
            $tbl->addChild('_estrutura', json_encode($campos));
        }
        $this->salvar();
    }

    public function insert($tabela, $dados) {
        $tbl = $this->xml->{$tabela};
        if (!$tbl) throw new Exception("Tabela $tabela não existe");

        $estrutura = json_decode((string) $tbl->_estrutura, true);
        $campos = array_keys($estrutura);
        $registro = $tbl->addChild('registro');

        // Inserção múltipla
        if (isset($dados[0]) && is_array($dados[0])) {
            foreach ($dados as $linha) {
                $this->inserirLinha($tbl, $estrutura, $linha);
            }
            $this->salvar();
            return true;
        }

        // Inserção simples
        $id_gerado = $this->inserirLinha($tbl, $estrutura, $dados);
        $this->salvar();
        return $id_gerado;
    }

    private function inserirLinha($tbl, $estrutura, $dados) {
        $campos = array_keys($estrutura);
        $linha = $tbl->addChild('registro');
        $out = [];

        foreach ($estrutura as $campo => $def) {
            $tipo = $def[0];

            // AUTO
            if ($tipo === 'int' && in_array('auto', $def)) {
                $max = 0;
                foreach ($tbl->registro as $reg) {
                    $valor = (int)$reg->{$campo};
                    if ($valor > $max) $max = $valor;
                }
                $id = $max + 1;
                $linha->addChild($campo, $id);
                $out[$campo] = $id;
                continue;
            }

            // Pegando valor
            $valor = is_array($dados)
                ? (array_keys($dados) === range(0, count($dados) - 1)
                    ? array_shift($dados) // modo sem nome das colunas
                    : $dados[$campo] ?? '')
                : '';

            $linha->addChild($campo, $valor);
            $out[$campo] = $valor;
        }

        return $out[array_keys($out)[0]] ?? null; // retorna ID auto, se houver
    }

    public function sel($tabelas) {
    if (!$this->xml) {
        return false; // Retorna false se o arquivo não foi carregado
    }

    $tabelas = (array)$tabelas;
    $resultado = [];

    // Verifica se a tabela base existe
    if (!isset($this->xml->{$tabelas[0]})) {
        return [];
    }

    foreach ($this->xml->{$tabelas[0]}->registro as $registro1) {
        $linha = [];
        foreach ($registro1 as $campo => $valor) {
            $linha[$campo] = (string)$valor;
        }

        // JOIN com outras tabelas
        if (count($tabelas) > 1) {
            for ($i = 1; $i < count($tabelas); $i++) {
                $tabelaJoin = $tabelas[$i];

                if (!isset($this->xml->{$tabelaJoin})) {
                    continue; // Pula se a tabela de join não existir
                }

                foreach ($this->xml->{$tabelaJoin}->registro as $registro2) {
                    if (isset($linha['id_login']) && isset($registro2->id_login)) {
                        if ((string)$registro2->id_login === $linha['id_login']) {
                            foreach ($registro2 as $campo => $valor) {
                                if ($campo === 'id_login') continue;
                                $linha[$campo] = (string)$valor;
                            }
                        }
                    }
                }
            }
        }

        // Só adiciona linhas não vazias
        if (!empty(array_filter($linha, fn($v) => $v !== ''))) {
            array_unshift($resultado, $linha); // mantém ordem reversa
        }
    }

    return $resultado;
}


    /*public function delete($tabela, $condicoes) {
        $tbl = $this->xml->{$tabela};

        foreach ($tbl->registro as $i => $registro) {
            $match = true;
            foreach ($condicoes as $campo => $valor) {
                if ((string)$registro->{$campo} !== (string)$valor) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                unset($tbl->registro[$i]);
            }
        }

        $this->salvar();
    }*/

    public function delete($tabela, $condicoes) {
        $tbl = $this->xml->{$tabela};
        if (!$tbl) return false;

        // converte para DOM para poder remover nós
        $dom = dom_import_simplexml($tbl);
        foreach ($tbl->registro as $registro) {
            $match = true;
            foreach ($condicoes as $campo => $valor) {
                if ((string)$registro->{$campo} !== (string)$valor) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                $node = dom_import_simplexml($registro);
                $node->parentNode->removeChild($node);
            }
        }

        $this->salvar();
        return true;
    }





    

    public function update($tabela, $condicoes, $novosDados) {
        $tbl = $this->xml->{$tabela};
        $estrutura = json_decode((string)$tbl->_estrutura, true);
        $campos = array_keys($estrutura);

        foreach ($tbl->registro as $registro) {
            $match = true;
            foreach ($condicoes as $campo => $valor) {
                if ((string)$registro->{$campo} !== (string)$valor) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                if (array_keys($novosDados) === range(0, count($novosDados) - 1)) {
                    // Atualização sequencial (sem nomes)
                    $i = 0;
                    foreach ($campos as $campo) {
                        if (isset($novosDados[$i])) {
                            $registro->{$campo} = $novosDados[$i];
                        }
                        $i++;
                    }
                } else {
                    // Atualização com nomes
                    foreach ($novosDados as $campo => $valor) {
                        if (isset($registro->{$campo})) {
                            $registro->{$campo} = $valor;
                        }
                    }
                }
            }
        }

        $this->salvar();
    }

    private function salvar() {
        $this->xml->asXML($this->arquivo);
    }
}
/* a função excluir não esta funcionando  :$b->delete('projeto', ['id_projeto' => $_POST['id']]);*/






/*$b = new BancoTxt('diretorio/arquivo.xml', 'utf8');

// Criar as tabelas
$b->newBanco([
    'TabelaLogin' => [
        'id_login' => ['int', 'auto'],
        'senha' => ['varchar', '30'],
        'email' => ['varchar', '150']
    ],
    'TabelaCadastro' => [
        'id_login' => ['int'],
        'mome' => ['varchar', '30'],
        'endereco' => ['varchar', '90'],
        'numero' => ['int', '4'],
        'data' => ['date'],
        'cadastro' => ['datetime'],
        'salario' => ['float', '4', '2']
    ]
]);

// Inserções
$id_lucas = $b->insert('TabelaLogin', [
    'email' => 'lucas@gmail.com',
    'senha' => 'senha123'
]);

$id_eduardo = $b->insert('TabelaLogin', ['senha3456', 'eduardo@gmail.com']);

$b->insert('TabelaCadastro', [
    [$id_lucas, 'lucas mánaces', 'av rio branco', '9875', '1995-06-30', '2025-10-30 10:22:15', '5623.23'],
    [$id_eduardo, 'eduardo silva', 'av rio branco', '98756', '1995-06-30', '2025-10-30 10:22:15', '65623.233'],
]);

// Seleções
$lista_login = $b->sel('TabelaLogin');
$lista_completa = $b->sel(['TabelaLogin', 'TabelaCadastro']);

// Atualização
$b->update('TabelaLogin', ['id_login' => $id_lucas], ['senha' => 'novasenha', 'email' => 'novoemailedu@gmail.com']);

// Exclusão
$b->delete('TabelaLogin', ['id_login' => $id_lucas]);
*/
?>
