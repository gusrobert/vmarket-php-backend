# vmarket-php-backend

> CRUD básico para gerenciamento de produtos e fornecedores — Projeto para vaga na VMarket

## Tecnologias Utilizadas
- **PHP** (sem frameworks)
- **HTML5**
- **Bootstrap** (via CDN)
- **Choices.js** (via CDN)
- **SweetAlert2** (via CDN)
- **MySQL** (banco de dados)
- **PDO** (acesso ao banco no backend)

## Funcionalidades
- Cadastro, edição, listagem e exclusão de produtos
- Cadastro, edição, listagem e exclusão de fornecedores
- Associação de múltiplos fornecedores a um produto
- Busca de produtos por nome e fornecedor
- Busca de fornecedores por nome
- Exclusão múltipla e total de fornecedores, com confirmação visual (SweetAlert2)
- Interface responsiva e amigável

## Estrutura do Projeto
- `models/` — Lógica de acesso a dados (Produto, Fornecedor)
- `controllers/` — Lógica de controle e regras de negócio
- `views/` — Telas de cadastro, edição e listagem (produtos e fornecedores)
- `database/` — Scripts SQL para criação e popular banco
- `index.php` — Página inicial

## Dependências
Todas as dependências externas (Bootstrap, Choices.js, SweetAlert2) são importadas via CDN, não sendo necessário instalar nada além do PHP.


## Banco de Dados

1. Crie um banco de dados MySQL chamado `vmarket` (ou altere o nome no arquivo `config.php`).
2. Execute os scripts SQL localizados na pasta `/database` para criar as tabelas e popular dados de teste:
   - `schema.sql`: Criação das tabelas necessárias
   - `seeds.sql`: Dados de exemplo para testes
3. As credenciais padrão de acesso ao banco estão em `config.php`:
   ```php
   $host = 'localhost';
   $dbname = 'vmarket';
   $username = 'root';
   $password = 'admin';
   ```
   Altere conforme necessário para o seu ambiente.

## Como rodar o projeto
1. Siga as instruções acima para configurar o banco de dados.
2. Ajuste as credenciais de conexão no arquivo de configuração (`config.php`).
3. Suba o servidor PHP embutido:
   ```sh
   php -S localhost:8080
   ```
   (ou qualquer porta de sua preferência)
4. Acesse no navegador:
   ```
   http://localhost:8080
   ```

---

Desenvolvido para fins de avaliação técnica na VMarket.
