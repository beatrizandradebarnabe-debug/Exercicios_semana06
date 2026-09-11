# Teóricos de Fixação - 

## Diferença Estrutural: GET x POST

- **GET** : os dados são enviados pela URL. 

**Exemplo:**
>site.com/pagina.php?nome=Ana&idade=20

- **POST** : os dados são enviados **dentro do corpo da requisição HTTP**, não aparecendo na URL.

**Resumo**:
GET -> dados ficam na URL
POST -> dados ficam no corpo da requisição.

---

# Segurança e privacidade
Senhas **nunca devem ser enviadas via GET**, porque elas podem aparecer na URL e ficar armazenadas em locais como:

1. **Histórico do navegador.**
2. **Logs do servidor.**
3. **Histórico/cache de sistemas de proxy**
4. Podem também aparecer quanto uma URL é copiada ou Compartilhada.

Por isso, para senhas, normalmente usamos **POST + HTTPS**

---

# Coalescência nula

Quando escrevemos:
```php
$nome = $_POST['nome'];
```
na primeira vez que abrimos a página, provavelmente **ainda não enviamos o formulário.**

Então
 >$_POST['nome'] 

não existe, e o PHP pode gerar um **Warning**, dizendo que a chave nome não foi encontrada.

## Podemos usar ??:

```php
$nome = $_POST['nome'] ?? '';
```

Significa:
>"Se $_POST['nome'] existir, use o valor. Se não existir, use uma string vazia."
Isso evita o Warning.

# Idempotência
Uma requisição **GET idempotente** significa que fazer a mesma requisição várias vezes deve ter o mesmo efeito sobre os dados do servidor.

Por exemplo:
>GET /produtos.php

Podemos atualizar a página várias vezes sem alterar os produtos.

Usar GET para **deletar ou alterar dados** é uma má prática porque um simples clique em um link, atualização da página ou acesso automático pode executar uma ação que modifica o banco.

Por exemplo, isso é perigoso:
>/deletar.php?id=10

O ideal é utilizar POST (ou outros métodos HTTP apropriados) para ações que modificam dados.

# Validação Client x Server
A afirmação é falsa.

>required e type="email" 
são validações feitas pelo navegador (client-side).

**O usuário pode:**

- desativar o JavaScript;
- modificar o HTML;
- enviar uma requisição manualmente;
- utilizar ferramentas como o DevTools.

Por isso, o servidor precisa validar os dados novamente.

Exemplo:
```php
$email = $_POST['email'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "E-mail inválido";
}
```
**Regra importante:** nunca confie somente na validação do navegador.

# XSS e htmlspecialchars()
Se exibirmos diretamente um valor recebido pelo usuário:
 
 ```php
 echo $_POST['nome'];
 ```

existe risco de XSS (Cross-Site Scripting).

Um usuário mal-intencionado poderia enviar código HTML/JavaScript em vez de apenas um nome.

Para exibir o conteúdo com segurança: 
```php
$nome = $_POST['nome'] ?? '';

echo htmlspecialchars($nome);
```
O **htmlspecialchars()** transforma caracteres especiais em entidades HTML, ajudando a impedir que o navegador interprete o conteúdo enviado como código HTML.

# Sticky Forms
**Sticky Forms** é uma técnica que faz o formulário **manter os dados que o usuário já digitou** quando ocorre algum erro de validação.

Por exemplo, o usuário preenche:
```php
Nome: Bia
E-mail: bia@email
```

Se o e-mail for inválido, em vez de apagar tudo, o formulário continua mostrando:
```php
Nome: Bia
E-mail: bia@email
```

Isso melhora bastante a UX (experiência do usuário), porque a pessoa não precisa preencher novamente todos os campos.

Em PHP, podemos fazer algo assim:
```php
$nome = $_POST['nome'] ?? '';

echo "<input type='text' name='nome' value='" . htmlspecialchars($nome) . "'>";
```

# DevTools — aba Network
Para verificar se o formulário foi enviado via **POST:**

1. Abra o site no navegador.
2. Pressione F12 para abrir o DevTools.
3. Entre na aba Network.
4. Envie o formulário
5. Procure a requisição feita para a página.
6. Clique nela.
7. Procure o campo Request Method.
 
 Se aparecer:
 ```php
 Request Method: POST
 ```
 o formulário foi enviado via POST.

Se aparecer:
```php
Request Method: GET
```
foi enviado via GET.

No caso do GET, também é possível perceber os dados na URL. No POST, os dados normalmente aparecem na seção Payload / Form Data da requisição.