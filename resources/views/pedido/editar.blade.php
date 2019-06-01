@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
@include('users.partials.header', [
'title' => '',
'description' => '',
'class' => 'col-lg-7'
])

@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-10 mx-auto order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="col-12 mb-0">Novo pedido</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('pedido.update', $pedido->pedido_id) }}" autocomplete="off">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <h6 class="heading-small text-muted mb-4">Informações sobre o pedido</h6>
                            </div>
                            <div class="col-12 col-md-6">
                                <h6 class="heading-small text-muted text-right mb-4">Valor total: 
                                    <span id="valorTotal">
                                            @php
                                            $valorTotal = 0;
                                            @endphp    
                                                
                                            @foreach ($pedido->pedido_produtos as $produto)
                                                @php
                                                    $valorTotal += (float) $produto->produto->valor;
                                                @endphp
                                            @endforeach
        
                                            R$ {{ number_format($valorTotal, 2, ',', '.') }}
                                    </span>
                                </h6>
                            </div>
                        </div>

                        @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-12 col-md-8">
                                    <div class="form-group{{ $errors->has('nome') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-nome">Nome do(a) cliente</label>
                                        <input type="text" name="nome" id="input-nome" class="form-control form-control-alternative{{ $errors->has('nome') ? ' is-invalid' : '' }}" placeholder="Nome do(a) cliente ou código" value="{{ old('nome', $pedido->cliente->nome) }}" required autofocus>
                                        <input type="hidden" name="cliente_id" value="{{ old('cliente_id', $pedido->cliente->cliente_id) }}">

                                        @if ($errors->has('nome'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nome') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-status">Status do pedido</label>
                                        <select name="status" id="input-status" class="form-control form-control-alternative{{ $errors->has('status') ? ' is-invalid' : '' }}" placeholder="Status do(a) pedido" required autofocus>
                                            <option value="">Selecione o status</option>
                                            <option value="reservado" {{ ($pedido->status === 'reservado') ? 'selected' : '' }}>Reservado</option>
                                            <option value="pago" {{ ($pedido->status === 'pago') ? 'selected' : '' }}>Pago</option>
                                            <option value="cancelado" {{ ($pedido->status === 'cancelado') ? 'selected' : '' }}>Cancelado</option>
                                        </select>
        
                                        @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="produtos">
                                @forelse ($pedido->pedido_produtos as $produto)
                                <div class="row produto">
                                    <div class="col-12 col-md-8">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-valor">Produto</label>
                                            <input type="text" class="input-produto form-control form-control-alternative" placeholder="Nome do Produto" value="{{ $produto->produto->nome }}" required autofocus disabled>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 dados d-flex align-items-center">
                                        <h3 class="valor">R$ {{ number_format($produto->produto->valor, 2, ',', '.') }}</h3>
                                    </div>
                                </div>
                                @empty
                                    
                                @endforelse
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-success mt-4">Atualizar pedido</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection

@push('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function () {
        $("#input-nome").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "/admin/json/clientes",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function (data) {
                        response(data);

                        
                    }
                });
            },
            minLength: 2,
            delay: 100,
            select: function(e, ui) {
                $(this).next('input[type=hidden]').val(ui.item.cliente_id)
            }
        })

    })

    var calculoTotal = function() {
        var valorTotal = 0
        $valorProduto = document.querySelectorAll('.valor')

        $valorProduto.forEach(function(val) {
            valor = parseFloat(val.getAttribute('data-valor'))
            
            valorTotal = valorTotal + valor
        })    

        return valorTotal.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})
    }

    // Eventos que são capturados mesmo havendo alterações no DOM
    document.querySelector('body').addEventListener('change', function (e) {
        $('#valorTotal').html(calculoTotal())
    })
</script>
@endpush
