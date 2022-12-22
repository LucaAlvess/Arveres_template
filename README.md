# Arveres Template

**Arveres Template** é um template engine com funcionalidades básicas 100% nativa em PHP.

## Instalação

Para instalar **Arveres Template**, você o comando composer diretamente em seu terminal:
```shell 
$ composer require arveres/
```
ou você pode adicionar a seguinte linha em seu arquivo `composer.json`.

```
{
    "require": {
        "arveres/": "^1.0"
    }
}
```
Em seguida, execute o comando:
```shell
$ composer install
```

## Exemplo de uso:
Vamos assumir a seguinte estrutura de diretórios e arquivos:
```
-- path
    -- to
        -- template
            |-- main.php
            |-- home.php
```

#### Renderização simples
```PHP
require_once 'vendor/autoload.php';

use ArveresTemplate\Engine;
use ArveresTemplate\Macros;

//Cria a instância e define o diretório das views
$engine = new Engine('/path/to/template');

//Adiciona classe com funções para o templete engine
$engine->dependencies([new Macros()]);

//Renderiza o template
echo $engine->render('home', ['foo' => 'bar']);
```
#### Estendendo Template
>home.php
```PHP
<?php $this->extends('main', ['title' => 'home page']) ?>

<h1>Home page</h1>
<p>Hello world, <?php echo $this->foo ?>.</p>
```
#### Carregando conteúdo no template
>main.php
```PHP
<html>
    <head>
       <title><?php echo $this->title ?></title>
    </head>
    <body>
        <?php echo $this->load() ?>
    </body>
</html>
```

#### Utilizando funções com o template engine 

```PHP
<body>
    <ul>
        <?php
             foreach ($this->users as $user) {
                echo '<li>' . $this->lower($user->name) . '</li>';
             } 
        ?>
    </ul>

</body>

```
Lista de funções disponíveis:
- **lower** - Converte uma string para minúsculas
- **upper** - Converte uma string para maiúsculas
- **uc** - Converte o primeiro caractere da string para maiúsculo e restante para minúsculo

#### Requisitos
- PHP 8.0 ou superior