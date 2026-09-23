# Fly Eventos

Sistema de gerenciamento de eventos desenvolvido em **PHP puro** (sem framework) com **MySQL**, seguindo o padrão **MVC** e utilizando **Design Patterns**. Todo o ambiente roda em **Docker**.

## Como executar

Pré-requisitos: Docker e Docker Compose instalados.

```bash
docker compose up -d --build
```

- Aplicação: http://localhost:8080
- phpMyAdmin: http://localhost:8081 (servidor `db`, usuário `fly_user`, senha `fly_pass`)

O banco de dados e as tabelas são criados automaticamente pelo script `database/init.sql` na primeira inicialização do container MySQL.

Para parar os containers:

```bash
docker compose down
```

Para apagar também os dados do banco:

```bash
docker compose down -v
```

## Funcionalidades

- **Cadastro / Login**: senhas armazenadas com hash `bcrypt` (`password_hash`/`password_verify`).
- **Dashboard**: lista de tarefas ("Minhas Tarefas") do usuário logado, com adição, conclusão e remoção.
- **Eventos** (tela própria, acessível pelo Dashboard): CRUD completo — criar, listar, editar e excluir eventos.

## Arquitetura (MVC)

```
public/            -> Front Controller (index.php) e assets públicos
src/
├── Controllers/    -> Controllers (Auth, Dashboard, Event)
├── Models/         -> Entidades (User, Task, Event)
├── Repositories/   -> Acesso a dados (camada Model/persistência)
├── Views/          -> Templates PHP (View)
├── Core/           -> Router, Controller base, Database (infra)
├── Factories/      -> Fábrica de Repositórios
└── routes.php      -> Definição das rotas
```

Todas as requisições passam pelo **Front Controller** (`public/index.php`), que delega o roteamento a `App\Core\Router`.

## Design Patterns utilizados

1. **Singleton** — `App\Core\Database` garante uma única conexão PDO com o MySQL compartilhada em toda a aplicação (`Database::getInstance()`).
2. **Factory Method** — `App\Factories\RepositoryFactory` centraliza a criação dos repositórios (`UserRepository`, `TaskRepository`, `EventRepository`), desacoplando os Controllers da forma como cada repositório é instanciado.
3. **Repository** (padrão arquitetural complementar) — cada entidade possui um repositório dedicado que isola o acesso ao banco de dados (SQL) do restante da aplicação.

## Segurança

- Senhas com hash `bcrypt` (`PASSWORD_BCRYPT`).
- Todas as queries usam **prepared statements** (PDO), prevenindo SQL Injection.
- Saída de dados nas Views escapada com `htmlspecialchars`, prevenindo XSS.
- Todas as rotas de Dashboard/Eventos exigem sessão autenticada (`requireAuth`).
- CRUD de tarefas e eventos sempre filtrado por `user_id`, isolando os dados de cada usuário.
