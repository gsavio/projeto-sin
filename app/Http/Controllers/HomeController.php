<?php

namespace App\Http\Controllers;

use App\Produto;
use App\Pedido;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Produto $produto, Pedido $pedido)
    {
        $ultimosProdutos = $produto->take(5)->orderBy('produto_id', 'desc')->get();

        $ultimosPedidos = $pedido->take(5)->orderBy('pedido_id', 'desc')->get();

        return view('dashboard', compact(['ultimosProdutos', 'ultimosPedidos']));
    }
}
