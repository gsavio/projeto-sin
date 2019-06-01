<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $primaryKey = 'cliente_id';

    protected $fillable = [
        'nome', 'email', 'cpf', 'cep', 'endereco', 'numero_casa', 'bairro', 'cidade', 'estado'
    ];
}
