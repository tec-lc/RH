CREATE TABLE `funcionario_ativo` (
   `cpf` int,
   `id_funcionario` int,
   `nome` varchar(110),
   `admissao` datetime,
   `nacimento` datetime,
   `id_funcao` int
);

CREATE TABLE `faltas` (
   `id_funcionario` int,
   `inicio` datetime,
   `fim` datetime,
   `tipo` datetime
);

CREATE TABLE `grupo` (
   `id_grupo` int,
   `nome_grupo` varchar(110),
   `valor` decimal(5,2),
   `obs` text
);

CREATE TABLE `funcao` (
   `id_funcao` int,
   `nome` varchar(110),
   `id_grupo` int
);