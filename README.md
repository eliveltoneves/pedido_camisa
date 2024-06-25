# Pedido de Camisas - Sistema de Gerenciamento

## Visão Geral

O sistema de gerenciamento de pedidos de camisas é uma aplicação web desenvolvida para facilitar a administração de pedidos de camisas personalizadas. Utilizando PHP, MySQL, HTML, CSS e JavaScript, o sistema permite aos administradores realizar operações de CRUD (Create, Read, Update, Delete) de forma eficiente e intuitiva.

Este projeto é parte integrante do curso de Análise e Desenvolvimento de Sistemas, e visa aplicar conhecimentos adquiridos ao longo do curso em um projeto prático e funcional.

## Funcionalidades

### Cadastro de Pedidos

- **Tela de Cadastro de Pedidos**: Permite o registro de novos pedidos com as informações do cliente, quantidade de camisas e especificações dos modelos e tamanhos.
- **Validação**: Verificação de campos obrigatórios e formatos corretos para garantir a integridade dos dados inseridos.

### Visualização de Pedidos

- **Tela de Visualização de Pedidos**: Exibe uma lista de todos os pedidos cadastrados com informações detalhadas.
- **Detalhamento**: Possibilidade de visualizar os detalhes de cada pedido, incluindo modelos e tamanhos das camisas.
- **Estatísticas**: Exibição de estatísticas como total de pedidos e quantidade de camisas por tipo e tamanho.

### Alteração de Pedidos

- **Tela de Alteração de Pedidos**: Permite a modificação das informações dos pedidos existentes.
- **Atualização Dinâmica**: Campos de modelo e tamanho são atualizados dinamicamente conforme a quantidade de camisas.

### Exclusão de Pedidos

- **Exclusão**: Opção de deletar pedidos, removendo também os dados associados de clientes e modelos de camisas.

### Confirmação de Pedido

- **Tela de Sucesso**: Exibe uma mensagem de confirmação quando um pedido é realizado com sucesso.

## Tecnologias Utilizadas

### Frontend

- **HTML5**: Estruturação das páginas web.
- **CSS3**: Estilização das páginas web, utilizando cores e design responsivo.
- **JavaScript**: Interatividade e manipulação dinâmica dos elementos na página.

### Backend

- **PHP**: Lógica do servidor e manipulação de dados.
- **MySQL**: Sistema de gerenciamento de banco de dados, utilizado para armazenar as informações dos pedidos e clientes.

### Servidor Local

- **XAMPP**: Ambiente de desenvolvimento que inclui Apache, MySQL, PHP e Perl, utilizado para criar o servidor local.

## Estrutura do Banco de Dados

### Tabela `clientes`

- **id**: Identificador único do cliente.
- **nome**: Nome do cliente.
- **telefone**: Telefone do cliente.
- **email**: Email do cliente.

### Tabela `pedidos`

- **id**: Identificador único do pedido.
- **cliente_id**: Chave estrangeira referenciando a tabela `clientes`.
- **quantidade**: Quantidade de camisas no pedido.

### Tabela `modelos_camisas`

- **id**: Identificador único do modelo de camisa.
- **pedido_id**: Chave estrangeira referenciando a tabela `pedidos`.
- **modelo**: Modelo da camisa (Manga, Regata, Nadador, Babylook).
- **tamanho**: Tamanho da camisa (PP, P, M, G, GG, EXG).

## Instalação e Configuração

### Requisitos

- XAMPP ou outro servidor local com PHP e MySQL instalados.

### Passos para Instalação

1. Clone o repositório para o diretório raiz do seu servidor web:

    ```bash
    git clone https://github.com/eliveltoneves/pedido_camisa.git
    ```

2. Importe o banco de dados:
    - Abra o phpMyAdmin.
    - Crie um banco de dados com o nome `pedido_camisas`.
    - Importe o arquivo `pedido_camisas.sql` localizado no diretório `sql`.

3. Configure a conexão com o banco de dados:
    - Edite o arquivo `db_connect.php` localizado no diretório `php` com as credenciais do seu banco de dados.

    ```php
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pedido_camisas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>
    ```

4. Inicie o servidor Apache e MySQL no XAMPP.

### Executando o Sistema

- Abra o navegador e acesse `http://localhost/pedido_camisa`.

## Contribuições

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues ou pull requests.

## Licença

Este projeto é licenciado sob os termos da licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## Contato

Para dúvidas ou sugestões, entre em contato:

- **Nome**: Elivelton Neves
- **Email**: [neves_elivelton@yahoo.com.br](neves_elivelton@yahoo.com.br)
- **GitHub**: [eliveltoneves](https://github.com/eliveltoneves)

## Referências

- [Documentação PHP](https://www.php.net/manual/pt_BR/index.php)
- [Documentação MySQL](https://dev.mysql.com/doc/)
- [Documentação HTML5](https://www.w3.org/TR/html5/)
- [Documentação CSS3](https://www.w3.org/Style/CSS/)
- [Documentação JavaScript](https://developer.mozilla.org/pt-BR/docs/Web/JavaScript)
- [Bootstrap Documentation](https://getbootstrap.com/docs/5.1/getting-started/introduction/)
- [XAMPP Official Website](https://www.apachefriends.org/index.html)
- [GitHub - pedido_camisa](https://github.com/eliveltoneves/pedido_camisa)
