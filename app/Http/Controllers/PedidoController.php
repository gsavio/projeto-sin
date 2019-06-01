<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use App\PedidoProduto;
use App\Http\Middleware\ChecarPermissao;

class PedidoController extends Controller
{

    public function __construct()
    {
        $this->middleware(ChecarPermissao::class)->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        $pedidos = Pedido::paginate(20);
        return view('pedidos', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pedido.criar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->middleware('VerifiyCsrfToken');

        $this->validate($request, [
            'cliente_id' => 'required|exists:clientes,cliente_id',
            'status' => 'required',
            'produto_id.*' => 'required|numeric|exists:produtos,produto_id',
        ],
        [
            'required' => 'Você deixou algum campo em branco, aguarde ele se autocompletar e tente novamente',
            'cliente_id.required'   => 'O nome do cliente é obrigatório',
            'cliente_id.exists'     => 'Este cliente não está cadastrado',
            'exists'                => 'Campo obrigatório',
            'produto_id.'
        ]);
        
        // Primeiro adiciona o pedido ao banco
        $pedido = new Pedido;
        $pedido->cliente_id = $request->cliente_id;
        $pedido->status = $request->status;
        $pedido->save();

        // Aidiciona um ou mais produtos ao pedido
        for($i = 0; $i < count($request->produto_id); $i++) {
            $pedidoProduto = new PedidoProduto;
            $pedidoProduto->pedido_id = $pedido->id;
            $pedidoProduto->produto_id = $request->produto_id[$i];
            $pedidoProduto->save();
        }

        return redirect()->route('pedido.index')->with('status', 'Pedido criado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id);

        return view('pedido.editar', compact($pedido));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
