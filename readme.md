## Descrição

Sistema de demonstração onde há a possibilidade de cadastrar e gerenciar clientes, produtos e podendo gerar pedidos para cada cliente.

## Instalação

Instale as depedências e o framework via composer executando:

```console
$ composer install
```

E em seguida rode as migrations para criar as tabelas do banco de dados juntamente com os seeds para popular as tabelas 

```console
$ php artisan migrate --seed
```

O login padrão será `admin@admin.com` e a senha `12345678`

## Sobre 

Utilizados neste projeto:

- [Laravel](https://laravel.com)
- [Argon](https://github.com/laravel-frontend-presets/argon)