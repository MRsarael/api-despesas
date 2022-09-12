<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Sobre o projeto

API de um CRUD de despesas pessoais com autenticação via JWT.

## Passos para configurar o projeto para teste

```bash
git clone https://github.com/MRsarael/api-despesas.git
composer install
php artisan key:generate
php artisan jwt:secret
composer dump-autoload
OBS: Será necessário criar um banco de dados Mysql e configurar o acesso no arquivo .env
php artisan migrate
```

## Rotas disponíveis

| Rota                  | Método    | Descrição                            |
| --------------------- | --------- | ------------------------------------ |
|`/user/login`          | `POST`    | Login de usuário                     |
|`/user/new`            | `POST`    | Novo usuário                         |
|`/user/me`             | `POST`    | Retorna dados do usuário logado      |
|`/user/logout`         | `POST`    | Logout de usuário                    |
|`/expenses`            | `GET`     | Lista de despesas do usuário logado  |
|`/expenses`            | `POST`    | Cadastro de despesa                  |
|`/expenses`            | `PUT`     | Edição de despesa                    |
|`/expenses/{expenseId}`| `GET`     | Lista de despesa específica          |
|`/expenses/{expenseId}`| `DELETE`  | Exclusão de despesa                  |

## Link collection Postman

<p>https://www.postman.com/collections/38db7d75059b055d9577</p>
