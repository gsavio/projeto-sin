@extends('layouts.app')

@section('content')
@include('users.partials.header', [
        'title' => '',
        'description' => '',
        'class' => ''
    ]) 

<div class="container-fluid mt--7">
    <div class="row mt-5">
        <div class="col-xl-12 mx-auto mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">

                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Clientes</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('cliente.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Novo cliente</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Código - Nome (Cliente)</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">CPF</th>
                                <th scope="col">Endereço</th>
                                <th scope="col">Cadastrado em</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $cliente)
                            <tr>
                                <th scope="row">
                                    <strong>{{ $cliente->cliente_id }}</strong> - {{ $cliente->nome }}
                                </th>
                                <td>
                                    {{ $cliente->email }}
                                </td>
                                <td>
                                    {{ $cliente->cpf }}
                                </td>
                                <td>
                                    {{ $cliente->endereco}}, {{ $cliente->numero_casa }} <br /> {{ $cliente->bairro }}<br />{{ $cliente->cidade }} - {{ $cliente->estado }}
                                </td>
                                <td>{{ date('d/m/Y', strtotime($cliente->created_at)) }}</td>
                                <td class="d-flex">
                                    <a class="btn btn-sm btn-primary" href="{{ route('cliente.edit', $cliente->cliente_id) }}">Editar</a> 

                                    <form class="deletar" action="{{ route('cliente.destroy', $cliente->cliente_id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        
                                        <button class="btn btn-sm btn-danger" type="submit">Excluir</button> 
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5 d-flex justify-center">
                    {!! $clientes->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection

@push('js')
    <script>
        $(function() {
            $('.deletar').on('submit', function(e) {
                let confirma = confirm('Você deseja excluir este cliente?')

                if(!confirma) {
                    e.preventDefault()
                }
            })
        })
    </script>
@endpush
