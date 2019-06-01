<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoProduto extends Model
{
    protected $fillable = ['pedido_id', 'produto_id'];

    public $timestamps = false;

    public function produto() 
    {
        return $this->belongsTo('App\Produto', 'produto_id', 'produto_id');
    }
}
