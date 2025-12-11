crie uma classe que unifica array e armazena em um arquivoassim

$val2 = [
    'BASE ATIVOS' => [

        'Nome' => [
            0 => 'ADRIANA AKILA DAMASCENO RIBEIRO',
            1 => 'ADRIANA DE OLIVEIRA SILVA',
            2 => 'ALAN GOMES ROSA',
            3 => 'ALANA EVELYN PEREIRA SILVA',
       
         
        ],
        'Grupo' => [
            0 => 'adm',
            1 => 'atendente',
            2 => 'adm',
            3 => 'atendente',
        ]
    ]
];


$val = [
    
    'BASE INATIVOS' => [

        'Nome' => [
            0 => 'RIBEIRO',
            1 => 'Lucio',
   
       
         
        ],
        'Grupo' => [
            0 => 'adm',
            1 => 'atendente',
        ],
    ],
];

 
$var= new MontaArray();
$var->add($val2);
$var->add($val);

$var->salva('pasta/array.php');
//cria oarquivo assim com ajunção das arrays:
 <?php $val=[

    'BASE ATIVOS' => [

        'Nome' => [
            0 => 'ADRIANA AKILA DAMASCENO RIBEIRO',
            1 => 'ADRIANA DE OLIVEIRA SILVA',
            2 => 'ALAN GOMES ROSA',
            3 => 'ALANA EVELYN PEREIRA SILVA',
       
         
        ],
        'Grupo' => [
            0 => 'adm',
            1 => 'atendente',
            2 => 'adm',
            3 => 'atendente',
        ],
    ],




    'BASE INATIVOS' => [

        'Nome' => [
            0 => 'RIBEIRO',
            1 => 'Lucio',
   
       
         
        ],
        'Grupo' => [
            0 => 'adm',
            1 => 'atendente',
        ],
    ],

]; ?>
