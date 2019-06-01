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
                    <form method="post" action="{{ route('pedido.store') }}" autocomplete="off">
                        @csrf
                        @method('post')

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <h6 class="heading-small text-muted mb-4">Informações sobre o pedido</h6>
                            </div>
                            <div class="col-12 col-md-6">
                                <h6 class="heading-small text-muted text-right mb-4">Valor total: <span id="valorTotal">0,00</span></h6>
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
                                        <input type="text" name="nome" id="input-nome" class="form-control form-control-alternative{{ $errors->has('nome') ? ' is-invalid' : '' }}" placeholder="Nome do(a) cliente ou código" required autofocus>
                                        <input type="hidden" name="cliente_id">

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
                                        <select name="status" id="input-status" class="form-control form-control-alternative{{ $errors->has('status') ? ' is-invalid' : '' }}" placeholder="status do(a) cliente ou código" required autofocus>
                                            <option value="">Selecione o status</option>
                                            <option value="reservado">Reservado</option>
                                            <option value="pago">Pago</option>
                                            <option value="cancelado">Cancelado</option>
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
                                <div class="row produto">
                                    <div class="col-12 col-md-8">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-valor">Produto</label>
                                            <input type="text" class="input-produto form-control form-control-alternative" placeholder="Nome do Produto" required autofocus />

                                            @if ($errors->has('produto_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('produto_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <input type="hidden" name="produto_id[]">
                                    </div>
                                    <div class="col-12 col-md-4 dados d-flex align-items-center">
                                        <h3 class="valor"></h3>
                                    </div>
                                </div>

                                {{-- <div class="row produto campo-extra">
                                    <div class="col-12 col-md-8">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-valor">Produto</label>
                                            <input type="text" class="input-produto form-control form-control-alternative ui-autocomplete-input" placeholder="Nome do Produto" required="" autofocus="" autocomplete="off">

                                                                                    </div>
                                        <input type="hidden" name="produto_id[]" value="">
                                    </div>
                                    <div class="col-12 col-md-4 dados d-flex align-items-center">
                                        <h3 class="valor"></h3>
                                    </div>
                                    <div class="excluir-campo" onclick="excluirCampo(this)"><i class="far fa-trash-alt"></i></div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-8 text-center">
                                    <a class="btn btn-primary mt-2 novo-produto" onclick="addCampo('produto')"><i class="fas fa-plus"></i> Adicionar produto</a>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-success mt-4">Criar pedido</button>
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

        autocompletarProduto()

        $('.input-produto').on('change', function(e) {
            $(this).next('input').val(e.target.value)
        })
    })

    var autocompletarProduto = function() {
        $(".input-produto").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "/admin/json/produtos",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function (data) {
                        response(data);
                    },
                });
            },
            minLength: 2,
            delay: 100,
            select: function(e, ui) {
                console.log(ui.item)

                $(this).parents('div.col-12.col-md-8').children('input[type=hidden]').val(ui.item.produto_id)

                $(this).parents('div.produto')
                .children('.dados')
                .children('h3')
                .html(ui.item.valor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}))
                .attr('data-valor', ui.item.valor)
                
            }
        })
    }

    // Adiciona um campo idêntico ao selecionado
    var addCampo = function (tipo) {
        let inputs = document.querySelector('.' + tipo)
        let novosInputs = inputs.cloneNode(true)

        novosInputs.classList.add('campo-extra')

        // Limpa os campos do elemento clonado
        novosInputs.querySelectorAll('input, textarea, h3').forEach(function (input) {
            input.value = ''
            input.checked = false
            input.innerHTML = ''
        })

        document.querySelector('.' + tipo + 's').appendChild(novosInputs)

        let div = document.createElement('div')
        div.classList.add('excluir-campo')
        div.setAttribute('onclick', 'excluirCampo(this)')
        div.innerHTML = '<i class="far fa-trash-alt"></i>'

        botaoExcluir = novosInputs.children[0].appendChild(div)
        novosInputs.appendChild(botaoExcluir)
        autocompletarProduto()
        document.querySelector('.input-produto').focus()
    }

    var excluirCampo = function (el) {
        el.parentElement.remove()
        $('#valorTotal').html(calculoTotal())
    }

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
