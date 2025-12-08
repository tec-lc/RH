<?php
/*

<tabela nome="TabelaLogin">
  <coluna tipo="int" maximo="auto">id_login</coluna>
  <coluna tipo="varchar" maximo="30">senha</coluna>
  <coluna tipo="varchar" maximo="150">email</coluna>
  <dados>
    1<,>senha123<,>lucas@gmail.com<;>
    2<,>senha3456<,>eduardo@gmail.com<;>
    3<,>senha12356<,>vasti@gmail.com<;>
    4<,>senha3456899<,>junior@gmail.com<;>
  </dados>
</tabela>

<tabela nome="TabelaCadastro">
  <coluna tipo="int">id_login</coluna>
  <coluna tipo="varchar" maximo="30">nome</coluna>
  <coluna tipo="varchar" maximo="90">endereco</coluna>
  <coluna tipo="int" maximo="4">numero</coluna>
  <coluna tipo="date">data</coluna>
  <coluna tipo="datetime" maximo="90">cadastro</coluna>
  <coluna tipo="float" dca="4" dcb="2">salario</coluna>
  <dados>
    3<,>vasti de alcantara<,>av poaránapanema<,>2725<,>2025-02-30<,>2025-10-30 22:35:39<,>1952,36<;>
    4<,>junior de oliveira<,>av joão valadão<,>25<,>2025-02-30<,>2025-10-30 22:35:39<,>52,00<;>
  </dados>
</tabela>
*/




/*crie uma classe que armazene e utilize um arquivo.xml como banco de dados,
onde eu posso utilizar as seguintes funções*/
$b= new BancoTxt('diretorio/arquivo.xml','utf8');
//cria um xml como se fosse um banco
$b->newBanco([
  'TabelaLogin' => [
    'id_login' => ['int','auto'],//auto gera um valor numerico automaticamente
    'senha' => ['varchar','30'],//armazena até 30 caracteres
    'email' => ['varchar','150']//armazena até 30 caractares
  ],
  'TabelaCadastro' =>[
    'id_login' => ['int']//valor numerico sem limite determinados
    'mome' => ['varchar','30'],//um texto até 30 caracteres
    'endereco' => ['varchar','90'],//um texto com no maximo 30 caracteres
    'numero' => ['int','4'],//um valor numerico de no maximo 4 caractares
    'data' =>['date'],//campo expecifico pra data como: 2025-05-02
    'cadastro' =>['datetime'],//campo expecifico pra data e hora como: 2025-05-02 22:33:21
    'salario' => ['float','4','2']//campo expecifico para valores com ,4 casas antes do ponto virgula e 2 casas depois da virgula exe: 1265,32 ou 52,30
  ]

]);
//tambem posso inserir conteudo da tabela no mesmo arquivo:
$id_lucas=$b->insert(//se tiver "auto" ira retornar o ID :1 e o id_login ira preencher automaticamente porque é  auto
  'TabelaLogin',
  [
    'email'=>'lucas@gmail.com',//expecificando nome da coluna
    'senha'=>'senha123'
  ]
);
//ou eu posso chamar o metodo assim:
$id_eduardo=$b->insert(//se tiver "auto" ira retornar o ID :2 e o id_login ira preencher automaticamente porque é  auto
  'TabelaLogin',['senha3456','eduardo@gmail.com']//o conteudo tambem pode ser colucado na sequancia da coluna TabelaLogin sem precisar expecificar nome da coluna
);


//posso cadastrar varias linhas:
$b->insert('TabelaCadastro',
  [
    [$id_lucas,'lucas mánaces','av rio branco','9875','1995-06-30','2025-10-30 10:22:15','5623.23'],
    //ira armazenar: '1','lucas mánaces','av rio branco','9875','1995-06-30','2025-10-30 10:22:15','5623.23'
    [$id_eduardo,'eduardo silva','av rio branco','98756','1995-06-30','2025-10-30 10:22:15','65623.233'],
    //ira armazenar: '2','eduardo silva','av rio branco','8756','1995-06-30','2025-10-30 10:22:15','5623.23'

  ]
);

//tambem posso listar em uma array do regitro mais recente pro mais antigo:
$lista_login=$b->sel('TabelaLogin');//seleciona tabela 'TabelaLogin'
/*ira retornar:
0 => ['id_login'=>'2','senha'=>'senha3456','email'=>'eduardo@gmail.com']
1 => ['id_login'=>'1','senha'=>'senha123','email'=>'lucas@gmail.com']
*/
//tambem posso listar varias tabelas:
$lista_login=$b->sel(['TabelaLogin','TabelaCadastro']);//seleciona tabela 'TabelaLogin' junto com a tabela 'TabelaCadastro' levando em considereção que as 2 posuem a uma coluna 'id_login'
/*ira retornar:
0 => ['id_login'=>'2','senha'=>'senha3456','email'=>'eduardo@gmail.com','nome'=>'eduardo silva','endereco'=>'av rio branco','numero'=>'8756','data'=>'1995-06-30','cadastro'=>'2025-10-30 10:22:15','salario'=>'5623.23']
1 => ['id_login'=>'1','senha'=>'senha123','email'=>'lucas@gmail.com','nome'=>'lucas mánaces','endereco'=>'av rio branco','numero'=>'9875','data'=>'1995-06-30','cadastro'=>'2025-10-30 10:22:15','salario'=>'5623.23']
*/


//tambem posso ecluir todos os campos que possuem um determinado valor
$b->delete('TabelaLogin',['id_login'=>$id_lucas],//coluna 'id_login' da tabela 'TabelaLogin'com o valor id: 1
);

//tambem posso editar
$b->update('TabelaLogin',['id_login'=>$id_lucas],//coluna 'id_login' da tabela 'TabelaLogin'com o valor id: 1
  ['novasenha','novoemailedu@gmail.com']
);
//tambem posso editar colunas especificas
//tambem posso editar
$b->update('TabelaLogin',['id_login'=>$id_lucas],//coluna 'id_login' da tabela 'TabelaLogin'com o valor id: 1
  ['senha'=>'novasenha','email'=>'novoemailedu@gmail.com']
);
