@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
    <div class="row mt-5">
        <div class="col-xl-6 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Produtos</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('produtos') }}" class="btn btn-sm btn-primary">Ver todos</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nome do produto</th>
                                <th scope="col">Descricção</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ultimosProdutos as $produto)
                            <tr>
                                <th scope="row">
                                    {{ $produto->nome }}
                                </th>
                                <td>
                                    {{ $produto->descricao }}
                                </td>
                                <td>
                                    R$ {{ $produto->valor }}
                                </td>
                                <td>
                                    <strong><a href="{{ route('produto.edit', $produto->produto_id) }}">Editar</a></strong>
                                </td>
                            </tr>
                            @empty
                                <strong>Não há produtos cadastrados.</strong>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Últimos Pedidos</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('pedido.index') }}" class="btn btn-sm btn-primary">Ver todos</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nº do Pedido</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Valor Total</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ultimosPedidos as $pedido)
                                <tr>
                                    <th scope="col">#{{ $pedido->pedido_id }}</th>
                                    <th scope="col">{{ substr($pedido->cliente->nome, 0, 17) }}...</th>
                                    <th scope="col">
                                        @php
                                            $valorTotal = 0;
                                        @endphp    
                                            
                                        @foreach ($pedido->pedido_produtos as $produto)
                                            @php
                                                $valorTotal += (float) $produto->produto->valor;
                                            @endphp
                                        @endforeach
    
                                        R$ {{ number_format($valorTotal, 2, ',', '.') }}
                                    </th>
                                    <th scope="col">
                                        @if ($pedido->status === 'reservado')
                                            <strong class="text-info">{{ ucfirst($pedido->status) }}</strong>
                                        @elseif($pedido->status === 'pago')
                                            <strong class="text-success">{{ ucfirst($pedido->status) }}</strong>
                                        @else
                                            <strong class="text-danger">{{ ucfirst($pedido->status) }}</strong>
                                        @endif
                                    </th>
                                    <th scope="col">
                                        <strong><a href="{{ route('pedido.edit', $pedido->pedido_id) }}">Editar</a></strong>
                                    </th>
                                </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection

@push('js')
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
