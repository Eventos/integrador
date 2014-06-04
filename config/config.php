<?php
//DEFINA A PASTA RAÍZ DO SEU PROJETO
define('SITE_ROOT', '/var/www/projetoIntegrador/');

//DEFINA A URL BASE DO SEU PROJETO
define('URL_BASE', 'http://localhost/projetoIntegrador/');

//DEFINE O NOME DA PASTA DO SEU PROJETO PARA USO DO FRAMEWORK
define('FOLDER', '/Integrador/');

//DEFINA A CONDIFICAÇÃO QUE VOCÊ USA
header('Content-Type: text/html; charset=utf-8');

//CONEXÕES DO BANCO DE DADOS
//SERVIDOR
define('DB_SERVER', 'localhost');
//PORTA
define('DB_PORT', '3306');
//BANCO DE DADOS
define('DB_DATABASE', 'integrador');
//USUÁRIO DO BANCO
define('DB_USER', 'root');
//SENHA DO BANCO
define('DB_PASSWORD', '123456');