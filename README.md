# Documento com a pesquisa e análise sobre Prepared Statements
## O que são Prepared Statements?
Modelo mais seguro de fazer comandos SQL. Separam o comando dos dados que o usuário envia, usando marcadores como ? para colocar os valores depois.
Com isso, ajuda a evitar ataques de SQL injection, porque os dados enviados pelo usuário não são como parte do comando SQL. Também tem quando a consulta é usada várias vezes, pode ajudar a melhorar o desempenho.

## Por que não colocar informações?
Não é recomendado colocar os dados diretamente no comando SQL porque as informações vem do usuário e podem ser alteradas.
- Por exemplo, nesse projeto temos no cadastro de livros as inserções como: 
```php
$sql = "insert into livros(titulo, autor, ano)values ('$titulo', '$autor', '$ano')".
```
No exemplo anterior, o titulo, o autor e o ano são colocados diretamente dentro do comando SQL. O problema é que uma pessoa poderia tentar colocar algum conteúdo diferente no campo e acabar interferindo no comando que vai para o banco de dados. Por isso, é melhor e mais seguro, separando os dados do comando usando Prepared Statements.

## O que é SQL injection?
SQL Injection acontece quando alguém tenta colocar comandos SQL em campos que o sistema recebe. Isso pode ser perigoso, pois pode permitir acesso, alteração ou exclusão de dados. Por isso, é importante proteger as consultas que recebem informacoes do usuário.

## Como que funciona um Prepared Statements?
No PHP com MySQLi, o Prepared Statement funciona em 3 etapas:

- Primeiro tem que preparar a consulta: usamos ? no lugar dos valores., que fica assim:

```php
$sql = "INSERT INTO livros (titulo, autor, ano) VALUES (?, ?, ?)";
```
- Depois temos que associar os parâmetros: Colocamos os valores nos ? da consulta.

- Por último executar: Usamos execute() para realizar a consulta.

Diante dessas etapas, os dados ficam separados do comando SQL, deixando mais segura a consulta.

## Análise do Projeto
O projeto é um CRUD simples para cadastrar livros, usando PHP, MySQL, HTML, CSS e XAMPP. Nele, da para cadastrar, consultar, atualizar e excluir livros.
A tabela `livros` tem informações como `id`, `titulo`, `autor` e `ano`.

## Problemas encontrados
Depois de analisar o codigo, encontrei alguns pontos que podem ser melhorados:
- Dados direto no SQL: No cadastro, os dados do livro são colocados diretamente na consulta. O mais seguro seria usar `?` e passar os valores separados.
- Atualização: Na atualização acontece a mesma coisa, os dados sao colocados direto no SQL. Tambem seria melhor usar Prepared Statements.
- ID na consulta: Na exclusão, o `id` vem pela URL e e colocado diretamente no comando. Por isso, o ideal é usar um parâmetro para deixar a consulta mais segura.

## Exemplo de alteração
Para testar o Prepared Statement, escolhi primeiro a parte de cadastro de livros.

### Código Original
```php
$titulo = $_POST["titulo"];
$autor = $_POST["autor"];
$ano = $_POST["ano"];

$sql = "INSERT INTO livros (titulo,autor,ano) VALUES ('$titulo','$autor','$ano')";

mysqli_query($conexao, $sql);
```
O problema dessa forma é que os valores recebidos pelo formulario são colocados diretamente dentro do SQL.

### Código com Prepared Statement
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
A principal mudança foi trocar os valores por ?:
```php
$sql = "INSERT INTO livros (titulo, autor, ano) VALUES (?, ?, ?)";
```

Depois a consulta é preparada:
```php
$stmt = mysqli_prepare($conexao, $sql);
```

Depois os valores são colocados nos lugares dos ?:
```php
mysqli_stmt_bind_param($stmt, "ssi", $titulo, $autor, $ano);
```

E por último a consulta é executada:
```php
mysqli_stmt_execute($stmt);
```
Assim, o comando SQL fica separado dos dados que o usuário digitou.

## Comparação
### Antes
```php
$sql = "INSERT INTO livros (titulo,autor,ano) VALUES ('$titulo','$autor','$ano')";

mysqli_query($conexao, $sql);
```
Os dados são colocados diretamente dentro do comando SQL.

### Depois
```php
$sql = "INSERT INTO livros (titulo, autor, ano) VALUES (?, ?, ?)";

$stmt = mysqli_prepare($conexao, $sql);

mysqli_stmt_bind_param($stmt, "ssi", $titulo, $autor, $ano);

mysqli_stmt_execute($stmt);
``` 
Os dados são enviados separadamente usando os parâmetros.
A principal diferença é que no segundo caso o que o usuario digitou não é tratado como parte do comando SQL.

## Conclusão 
Depois de analisar o projeto, entendi que os Prepared Statements ajudam a deixar as consultas SQL mais seguras.

No nosso CRUD, alguns dados do usuário eram colocados direto no SQL, o que pode causar problemas como SQL Injection. Com prepare, bind_param e execute, os dados ficam separados do comando, deixando o sistema mais seguro.
