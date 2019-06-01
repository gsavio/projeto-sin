<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use App\Http\Middleware\ChecarPermissao;
use App\PedidoProduto;
use Illuminate\Support\Facades\Input;

class ProdutoController extends Controller
{
    public function __construct()
    {
        $this->middleware(ChecarPermissao::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::paginate(20);

        return view('produtos', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produto.criar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nome'      => 'required|max:250',
                'valor'     => 'required',
                'descricao' => 'required'
            ],
            [
                'required' => 'O campo :attribute é obrigatório'
            ]
        );

        $produto = new Produto;

        $valor = str_replace('.', '', $request->valor);

        $produto->nome      = $request->nome;
        $produto->descricao = $request->descricao;
        $produto->valor     = str_replace(',', '.', $valor);

        $produto->save();

        return redirect()->route('produto.create')->with('status', 'Produto adicionado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $produtos = Produto::paginate(20);

        return view('produtos', compact('produtos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produto.editar', compact('produto'));
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
        $request->validate(
            [
                'nome'      => 'required|max:250',
                'valor'     => 'required',
                'descricao' => 'required'
            ],
            [
                'required' => 'O campo é obrigatório'
            ]
        );

        $produto = Produto::findOrFail($id);

        $valor = str_replace('.', '', $request->valor);

        $produto->nome      = $request->nome;
        $produto->descricao = $request->descricao;
        $produto->valor     = str_replace(',', '.', $valor);

        $produto->save();

        return redirect()->route('produto.edit', $produto->produto_id)->with('status', 'Produto atualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = Produto::find($id);
        $produto->delete();

        return redirect()->route('produto.index')->with('status', 'Produto deletado.');
    }

    public function listarProdutosJson() {
        $produto = Input::get('q');

        $produtos = Produto::select(DB::raw('nome as label'))
            ->where('nome', 'like', '%'. $produto .'%')
            ->orWhere('produto_id', 'like', '%'. $produto .'%')
            ->take(5)->get();

        return response()->json($produtos);
    }
}
