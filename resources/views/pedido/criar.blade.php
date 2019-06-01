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
                    <form method="post" action="{{ route('produto.store') }}" autocomplete="off">
                        @csrf
                        @method('post')

                        <h6 class="heading-small text-muted mb-4">Informações sobre o pedido</h6>

                        @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="pl-lg-4">
                            <div class="form-group{{ $errors->has('nome') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-nome">Nome do(a) cliente</label>
                                <input type="text" name="nome" id="input-nome"
                                    class="form-control form-control-alternative{{ $errors->has('nome') ? ' is-invalid' : '' }}"
                                    placeholder="Nome do(a) cliente ou código" required autofocus>

                                @if ($errors->has('nome'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nome') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="campos-produtos">
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <div class="form-group{{ $errors->has('valor') ? ' has-danger' : '' }} input-produto">
                                            <label class="form-control-label" for="input-valor">Produto</label>
                                            <input type="text" name="produto[]" id="input-valor"
                                                class="input-produto form-control form-control-alternative{{ $errors->has('valor') ? ' is-invalid' : '' }}"
                                                placeholder="Nome do Produto" required autofocus>

                                            @if ($errors->has('valor'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('valor') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <a class="btn btn-primary mt-2" onclick="addCampo('idioma')">Novo produto</a>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">Adicionar</button>
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
                        console.log(data)
                        response(data);
                    }
                });
            },
            minLength: 2,
            delay: 100,
        });

        $(".input-produto").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "/admin/json/produtos",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function (data) {
                        console.log(data)
                        response(data);
                    }
                });
            },
            minLength: 2,
            delay: 100,
        });
    })

    // Adiciona um campo idêntico ao selecionado
    var addCampo = function (tipo) {
        let inputs = document.querySelector('.' + tipo)
        let novosInputs = inputs.cloneNode(true)

        novosInputs.classList.add('campo-extra')

        // Limpa os campos do elemento clonado
        novosInputs.querySelectorAll('input, textarea').forEach(function (input) {
            input.value = ''
            input.checked = false
        })

        document.querySelector('.' + tipo + 's').appendChild(novosInputs)

        let div = document.createElement('div')
        div.classList.add('excluir-campo')
        div.setAttribute('onclick', 'excluirCampo(this)')
        div.innerHTML = '<i class="far fa-trash-alt"></i>'

        botaoExcluir = novosInputs.appendChild(div)
        novosInputs.appendChild(botaoExcluir)
    }

</script>
@endpush
