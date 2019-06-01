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
                            <h3 class="mb-0">Produtos</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('produto.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Adicionar produto</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nome do produto</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $produto)
                            <tr>
                                <th scope="row">
                                    {{ $produto->nome }}
                                </th>
                                <td>
                                    {{ $produto->descricao }}
                                </td>
                                <td>
                                    R$ {{ number_format($produto->valor, 2, ',', '.') }}
                                </td>
                                <td class="d-flex ">
                                    <a class="btn btn-sm btn-primary" href="{{ route('produto.edit', $produto->produto_id) }}">Editar</a> 

                                    <form class="deletar" action="{{ route('produto.destroy', $produto->produto_id) }}" method="POST">
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
                    {!! $produtos->links() !!}
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
                let confirma = confirm('Você deseja excluir este produto?')

                if(!confirma) {
                    e.preventDefault()
                }
            })
        })
    </script>
@endpush
