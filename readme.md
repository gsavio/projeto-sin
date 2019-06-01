## Descrição

Sistema de demonstração onde há a possibilidade de cadastrar e gerenciar clientes, produtos e podendo gerar pedidos para cada cliente.

## Instalação

Para funcionar, instale as depedências via composer executando:

E em seguida rode as migrations para criar as tabelas do banco de dados

```console
$ php artisan migrate
```

Em seguida, rode as seeds para alimentar o banco de dados com dados fakes para teste e criar o usuário Administrador

```console
$ php artisan db:seed
```

O login padrão será `admin@admin.com` e a senha `12345678`

**Contém um arquivo docker-compose gerado por [Ambientum](https://github.com/ambientum/ambientum)**

## Sobre 

Feito com:

- [Laravel](https://laravel.com)
- [Argon](https://github.com/laravel-frontend-presets/argon)