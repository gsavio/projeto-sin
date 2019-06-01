<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Http\Middleware\ChecarPermissao;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware(ChecarPermissao::class)->except(['index', 'listaClintesJson']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::paginate(20);

        return view('clientes', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cliente.criar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate(
            $request,
            [
                'nome'  => 'required|max:250',
                'email' => 'required|unique:clientes,email|email|max:150',
                'cpf'  => 'required|unique:clientes,cpf|max:14',
                'cep'   => 'required|max:9',
                'endereco' => 'required|max:150',
                'numero_casa' => 'max:150',
                'bairro' => 'required|max:100',
                'cidade' => 'required|max:150',
                'estado' => 'required|max:2'
            ],
            [
                'required' => 'O campo é obrigatório',
                'email.unique' => 'Este e-mail já está cadastro para outro cliente',
                'cpf.unique' => 'Este CPF já está cadastrado para outro cliente'
            ]
        );

        $cliente = new Cliente;
        $cliente->fill($request->all());
        $cliente->save();

        return redirect()->route('cliente.index')->with('status', 'Cliente ' . $request->nome . ' adicionado(a)');
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
        $cliente = Cliente::findOrFail($id);
        return view('cliente.editar', compact('cliente'));
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
        
        $this->validate(
            $request,
            [
                'nome'  => 'required|max:250',
                'email' => 'required|unique:clientes,email,'. $id .',cliente_id|email|max:150',
                'cep'   => 'required|max:9',
                'endereco' => 'required|max:150',
                'numero_casa' => 'max:150',
                'bairro' => 'required|max:100',
                'cidade' => 'required|max:150',
                'estado' => 'required|max:2'
            ],
            [
                'required' => 'O campo é obrigatório',
                'email.unique' => 'Este e-mail já está cadastro para outro cliente',
                'cpf.unique' => 'Este CPF já está cadastrado para outro cliente'
            ]
        );

        
        $cliente = Cliente::find($id);
        $cliente->fill($request->all());
        $cliente->save();

        return redirect()->route('cliente.edit', $id)->with('status', 'Cliente ' . $request->nome . ' atualizado(a)');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        $cliente->delete();

        return redirect()->route('cliente.index')->with('status', 'Cliente deletado.');
    }

    /**
     * Returna json com nomes dos clientes cadastrados
     * 
     * @return \Illuminate\Contracts\Routing\ResponseFactory::json
     */
    public function listaClientesJson() {
        $termo = Input::get('q');

        $clientes = Cliente::select(\DB::raw('nome as label, cliente_id'))
            ->where('nome', 'like', '%'. $termo .'%')
            ->orWhere('cliente_id', 'like', '%'. $termo .'%')
            ->take(5)->get();

        return response()->json($clientes);
    }
}
