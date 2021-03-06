<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'cliente_id', 'status'
    ];

    protected $primaryKey = 'pedido_id';

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'cliente_id', 'cliente_id');
    }

    
    public function pedido_produtos() 
    {
        return $this->hasMany(PedidoProduto::class, 'pedido_id', 'pedido_id');
    }
}
