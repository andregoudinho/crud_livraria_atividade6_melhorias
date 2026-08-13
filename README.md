# crud_livraria
# Documento com a pesquisa e analise sobre Prepared Statements

## O que sao Prepared Statements?
- Modelo mais seguro de fazer comandos SQL. Separam o comando dos dados que o usuario envia, usando marcadores como ? para colocar os valores depois.
- Com isso, ajuda a evitar ataques de SQL injection, porque os dados enviados pelo usuário não são como parte do comando SQL. Também tem quando a consulta é usada várias vezes, pode ajudar a melhorar o desempenho.

## Por que não colocar informacoes 
- Não é recomendado colocar os dados diretamente no comando SQL porque as informações vêm do usuário e podem ser alteradas.
- Por exemplo, nesse projeto temos no cadastro de livro as inserções como: $sql = "insert into livros(titulo, autor, ano)values ('$titulo', '$autor', '$ano')",
- No exemplo anterior, o titulo, o autor e o ano são colocados diretamente dentro do comando SQL. problema é que, uma pessoa poderia tentar colocar algum conteúdo diferente no campo e acabar interferindo no comando que vai para o banco de dados. Por isso, é melhor e mais seguro, separando os dados do comando usando Prepared Statements.

