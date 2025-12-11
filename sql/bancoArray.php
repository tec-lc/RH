<?php


$tabelas=[


    'funcionario_ativo' =>[
        ['cpf','int'],
        ['id_funcionario', 'int' ],
        ['nome','varchar(110)'],
        ['admissao','datetime'],
        ['nacimento','datetime'],
        ['id_funcao','int'],
    ],

    'faltas' =>[
        ['id_funcionario', 'int'],
        ['inicio', 'datetime'],
        ['fim', 'datetime'],
        ['tipo', 'varchar(3)'],//FAL , FER, ATE, Falta feria ou atestado
    ],

    'grupo' => [
        ['id_grupo','int'],
        ['nome_grupo','varchar(110)'],
        ['valor','decimal(5,2)'],
        ['tipo','varchar(2)'],//se é VA ou VR
        ['obs','text'],
    ],
   
    'funcao' => [
        ['id_funcao','int'],
        ['nome','varchar(110)'],
        ['id_grupo','int'],
    ],


];



$tabelas=[

    'funcionario_ativo' =>[
        ['cpf','int'],
        ['id_funcionario', 'int' ],
        ['nome','varchar(110)'],
        ['admissao','datetime'],
        ['nacimento','datetime'],
        ['id_funcao','int'],
    ],

    'faltas' =>[
        ['id_funcionario', 'int'],
        ['inicio', 'datetime'],
        ['fim', 'datetime'],
        ['tipo', 'varchar(3)'],//FAL , FER, ATE, Falta feria ou atestado
    ],

    'grupo' => [
        ['id_grupo','int'],
        ['nome_grupo','varchar(110)'],
        ['valor','decimal(5,2)'],
        ['tipo','varchar(2)'],//se é VA ou VR
        ['obs','text'],
    ],
   
    'funcao' => [
        ['id_funcao','int'],
        ['nome','varchar(110)'],
        ['id_grupo','int'],
    ],
    'setor' => [
        ['id_setor','int'],
        ['nome','varchar(110)']
    ],



];


























/*
$dados = [
    'nome de pessoas' => [
        'cpf da pessoa' => [
            0 => '23452346',
            1 => '345645',
            2 => '45645645',
        ],
        'codigo de cadastro' => [
            0 => 'dados2',
            1 => 'srgfdg',
            2 => 'dsfgdfg',
        ]
    ]
];


    //crie uma class em php que tranforme array em instrução mysql
    //assim
    $v = new ConverteMysql();
    echo $v->create($tabelas);//retorna instruções insert into mysql
    echo $v->insert($tabelas,$dados,
        [
            'nome de pessoas'=>[//estou concatenando com os indices das tabelas com os nomes dos dados sempre na sequancia
                'cpf da pessoa',
                'codigo de cadastro'
            ]
        ]
    );//a saida seria assim:
    insert into funcionario_ativo(cpf,id_funcionario) values('23452346','dados2'),
    ('345645','srgfdg')......
    e assim por diante

    */
?>