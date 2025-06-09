# Sistema de Ordem de Serviço

Este projeto é uma aplicação web desenvolvida como parte de um teste técnico para a vaga de Programador Pleno. O sistema simula o fluxo de abertura de ordens de serviço, incluindo funcionalidades de autenticação, CRUD de clientes e produtos, e registro de logs.

## 🧰 Tecnologias Utilizadas

- **Back-end:** PHP (Orientado a Objetos, API RESTful)
- **Front-end:** HTML, JavaScript, jQuery, Bootstrap
- **Banco de Dados:** PostgreSQL ou MySQL
- **Controle de Versão:** Git
- **Autenticação:** JWT (JSON Web Tokens)
- **Documentação da API:** Swagger (ou equivalente)

## 🚀 Como Executar o Projeto

### 1. Clone o Repositório

```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
```

### 2. Configure o Ambiente

- Renomeie `.env.example` para `.env` e configure as variáveis de ambiente.
- Instale as dependências necessárias via Composer:
```bash
composer install
```

### 3. Execute as Migrações

```bash
php artisan migrate
```

### 4. Inicie o Servidor Local

```bash
php artisan serve
```

### 5. Teste a Aplicação

- Acesse `http://localhost:8000` no navegador.
- Utilize ferramentas como Postman para testar as rotas protegidas com JWT.

## 📦 Funcionalidades Implementadas

- [ ] CRUD de Clientes com validação de CPF
- [ ] CRUD de Produtos com filtros e buscas
- [ ] CRUD de Ordem de Serviço
- [ ] Cadastro automático de cliente na OS
- [ ] Registro de logs de alterações
- [ ] Autenticação com JWT e controle de acesso por função (admin, usuário)
- [ ] Proteção contra SQL Injection e XSS
- [ ] Testes unitários e de integração
- [ ] Documentação da API

## 🧪 Testes

Os testes estão localizados na pasta `/tests`. Para rodá-los, utilize:

```bash
phpunit
```

## 🧾 Diagrama do Banco de Dados

![Diagrama do Banco de Dados](./docs/Diagrama.png)

## ✍️ Autor

**Rafael Ribeiro**  
Data: 9 de Junho de 2025