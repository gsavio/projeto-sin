@extends('layouts.app')

@section('content')
@include('users.partials.header', [
        'title' => '',
        'description' => '',
        'class' => ''
    ]) 

<div class="container-fluid mt--7">
    <div class="row mt-5">
        <div class="col-md-12 mx-auto mb-5 mb-xl-0">
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
                            <h3 class="mb-0">Pedidos</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('pedido.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Novo pedido</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col"># Pedido</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Produtos</th>
                                <th scope="col">Data do pedido</th>
                                <th scope="col">Valor total</th>
                                <th scope="col">Status do pedido</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                            <tr>
                                <th scope="row">
                                    #{{ $pedido->pedido_id }}
                                </th>
                                <td>
                                    <a href="{{ route('cliente.edit', $pedido->cliente_id) }}" target="_blank">{{ $pedido->cliente->nome }} <i style="font-size: 12px" class="fas fa-external-link-alt"></i></a>
                                </td>
                                <td>
                                    @foreach ($pedido->pedido_produtos as $produto)
                                        {{ $produto->produto->nome.', ' }}
                                    @endforeach
                                </td>
                                <td>
                                    {{ date('d/m/Y \à\s H:i', strtotime($pedido->created_at)) }}
                                </td>
                                <td>
                                    @php
                                        $valorTotal = 0;
                                    @endphp    
                                        
                                    @foreach ($pedido->pedido_produtos as $produto)
                                        @php
                                            $valorTotal += (float) $produto->produto->valor;
                                        @endphp
                                    @endforeach

                                    R$ {{ number_format($valorTotal, 2, ',', '.') }}
                                </td>                                
                                <td>
                                    @if ($pedido->status === 'reservado')
                                        <strong class="text-info">{{ ucfirst($pedido->status) }}</strong>
                                    @elseif($pedido->status === 'pago')
                                        <strong class="text-success">{{ ucfirst($pedido->status) }}</strong>
                                    @else
                                        <strong class="text-danger">{{ ucfirst($pedido->status) }}</strong>
                                    @endif
                                </td>
                                <td class="d-flex">
                                    <a class="btn btn-sm btn-primary" href="{{ route('pedido.edit', $pedido->pedido_id) }}">Editar</a> 

                                    <form class="deletar" action="{{ route('pedido.destroy', $pedido->pedido_id) }}" method="POST">
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
                    {!! $pedidos->links() !!}
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
                let confirma = confirm('Você deseja excluir este pedido?')

                if(!confirma) {
                    e.preventDefault()
                }
            })
        })
    </script>
@endpush
