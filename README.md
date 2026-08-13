# Documento com a pesquisa e analise sobre Prepared Statements
## O que sao Prepared Statements?
Modelo mais seguro de fazer comandos SQL. Separam o comando dos dados que o usuario envia, usando marcadores como ? para colocar os valores depois.
Com isso, ajuda a evitar ataques de SQL injection, porque os dados enviados pelo usuário nao sao como parte do comando SQL. Tambem tem quando a consulta e usada varias vezes, pode ajudar a melhorar o desempenho.

## Por que nao colocar informacoes?
Nao e recomendado colocar os dados diretamente no comando SQL porque as informaçoes vem do usuario e podem ser alteradas.
- Por exemplo, nesse projeto temos no cadastro de livro as insercoes como: 
```php
$sql = "insert into livros(titulo, autor, ano)values ('$titulo', '$autor', '$ano')".
```
No exemplo anterior, o titulo, o autor e o ano sao colocados diretamente dentro do comando SQL. O problema e que uma pessoa poderia tentar colocar algum conteudo diferente no campo e acabar interferindo no comando que vai para o banco de dados. Por isso, melhor e mais seguro, separando os dados do comando usando Prepared Statements.

## O que e SQL inection?
SQL Injection acontece quando alguem tenta colocar comandos SQL em campos que o sistema recebe. Isso pode ser perigoso, pois pode permitir acesso, alteracao ou exclusao de dados. Por isso, e importante proteger as consultas que recebem informacoes do usuario.

## Como que funciona um Prepared Statements?
No PHP com MySQLi, o Prepared Statement funciona em 3 etapas:

Primeiro tem que preparar a consulta: usamos ? no lugar dos valores., que fica assim:

```php
$sql = "INSERT INTO livros (titulo, autor, ano) VALUES (?, ?, ?)";
```
Depois temos que associar os parametros: Colocamos os valores nos ? da consulta.

E por ultimo executar: Usamos execute() para realizar a consulta.

Diante dessas etapas, os dados ficam separados do comando SQL, deixando mais segura a consulta.

## Analise do Projeto
O projeto e um CRUD simples para cadastrar livros, usando PHP, MySQL, HTML, CSS e XAMPP. Nele, da para cadastrar, consultar, atualizar e excluir livros.
A tabela `livros` tem informações como `id`, `titulo`, `autor` e `ano`.

## Problemas encontrados
Depois de analisar o codigo, encontrei alguns pontos que podem ser melhorados:
### Dados direto no SQL
No cadastro, os dados do livro sao colocados diretamente na consulta. O mais seguro seria usar `?` e passar os valores separados.
### Atualizacao
Na atualizacao acontece a mesma coisa, os dados sao colocados direto no SQL. Tambem seria melhor usar Prepared Statements.
### ID na consulta
Na exclusao, o `id` vem pela URL e e colocado diretamente no comando. Por isso, o ideal e usar um parametro para deixar a consulta mais segura.

## Exemplo de alteracao
Para testar o Prepared Statement, escolhi primeiro a parte de cadastro de livros.

### Codigo Original
```php
$titulo = $_POST["titulo"];
$autor = $_POST["autor"];
$ano = $_POST["ano"];

$sql = "INSERT INTO livros (titulo,autor,ano) VALUES ('$titulo','$autor','$ano')";

mysqli_query($conexao, $sql);
```
O problema dessa forma e que os valores recebidos pelo formulario sao colocados diretamente dentro do SQL.

## Codigo com Prepared Statement
Uma forma de fazer essa mesma parte de maneira mais segura seria:
```php
$titulo = $_POST["titulo"];
$autor = $_POST["autor"];
$ano = $_POST["ano"];

$sql = "INSERT INTO livros (titulo, autor, ano) VALUES (?, ?, ?)";

$stmt = mysqli_prepare($conexao, $sql);

mysqli_stmt_bind_param($stmt, "ssi", $titulo, $autor, $ano);

mysqli_stmt_execute($stmt);
```

## O que mudou?
A principal mudanca foi trocar os valores por ?:
```php
$sql = "INSERT INTO livros (titulo, autor, ano) VALUES (?, ?, ?)";
```

Depois a consulta e preparada:
```php
$stmt = mysqli_prepare($conexao, $sql);
```

Depois os valores sao colocados nos lugares dos ?:
```php
mysqli_stmt_bind_param($stmt, "ssi", $titulo, $autor, $ano);
```

E por ultimo a consulta e executada:
```php
mysqli_stmt_execute($stmt);
```
Assim, o comando SQL fica separado dos dados que o usuario digitou.

## Comparacao
### Antes
```php
$sql = "INSERT INTO livros (titulo,autor,ano) VALUES ('$titulo','$autor','$ano')";

mysqli_query($conexao, $sql);
```
Os dados sao colocados diretamente dentro do comando SQL.

### Depois
```php
$sql = "INSERT INTO livros (titulo, autor, ano) VALUES (?, ?, ?)";

$stmt = mysqli_prepare($conexao, $sql);

mysqli_stmt_bind_param($stmt, "ssi", $titulo, $autor, $ano);

mysqli_stmt_execute($stmt);
``` 
Os dados sao enviados separadamente usando os parametros.
A principal diferenca e que no segundo caso o que o usuario digitou nao e tratado como parte do comando SQL.

## Conclusão 
Depois de analisar o projeto, entendi que os Prepared Statements ajudam a deixar as consultas SQL mais seguras.

No nosso CRUD, alguns dados do usuário eram colocados direto no SQL, o que pode causar problemas como SQL Injection. Com prepare, bind_param e execute, os dados ficam separados do comando, deixando o sistema mais seguro.
