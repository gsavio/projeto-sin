@extends('layouts.app', ['title' => __('Adicionar cliente')])

@section('content')
    @include('users.partials.header', [
        'title' => '',
        'description' => '',
        'class' => 'col-lg-7'
    ]) 

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-10 mx-auto order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">Adicionar cliente</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('cliente.store') }}" autocomplete="off">
                            @csrf
                            @method('post')

                            <h6 class="heading-small text-muted mb-4">Informações sobre o cliente</h6>
                            
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
                                    <label class="form-control-label" for="input-nome">Nome *</label>
                                    <input type="text" name="nome" id="input-nome" class="form-control form-control-alternative{{ $errors->has('nome') ? ' is-invalid' : '' }}" placeholder="Nome" required autofocus>

                                    @if ($errors->has('nome'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nome') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-email">E-mail *</label>
                                            <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Endereço de e-mail" required autofocus>
    
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-6">
                                        <div class="form-group{{ $errors->has('cpf') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-cpf">CPF *</label>
                                            <input type="text" name="cpf" id="input-cpf" data-mask="000.000.000-00" data-mask-reverse="true" class="form-control form-control-alternative{{ $errors->has('cpf') ? ' is-invalid' : '' }}" placeholder="CPF do cliente" required autofocus>
    
                                            @if ($errors->has('cpf'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('cpf') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="row">
                                    <div class="col-12 col-md-5">
                                        <div class="form-group{{ $errors->has('cep') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-cep">CEP *</label>
                                            <input type="text" name="cep" id="input-cep" data-mask="00000-000" data-mask-reverse="true" onfocusout="buscarEndereco(this.value)" class="form-control form-control-alternative{{ $errors->has('cep') ? ' is-invalid' : '' }}" placeholder="CEP" required autofocus>
    
                                            @if ($errors->has('cep'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('cep') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-5">
                                        <div class="form-group{{ $errors->has('endereco') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-endereco">Endereço *</label>
                                            <input type="text" name="endereco" id="input-endereco" class="form-control form-control-alternative{{ $errors->has('endereco') ? ' is-invalid' : '' }}" placeholder="Endereço" required autofocus>
    
                                            @if ($errors->has('endereco'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('endereco') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-2">
                                        <div class="form-group{{ $errors->has('numero_casa') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-numero-casa">Número</label>
                                            <input type="number" name="numero_casa" id="input-numero-casa" class="form-control form-control-alternative{{ $errors->has('numero_casa') ? ' is-invalid' : '' }}" placeholder="Número" autofocus>
    
                                            @if ($errors->has('numero_casa'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('numero_casa') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="form-group{{ $errors->has('bairro') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-bairro">Bairro *</label>
                                            <input type="text" name="bairro" id="input-bairro" class="form-control form-control-alternative{{ $errors->has('bairro') ? ' is-invalid' : '' }}" placeholder="Bairro" required autofocus>
    
                                            @if ($errors->has('bairro'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('bairro') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-group{{ $errors->has('cidade') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-cidade">Cidade *</label>
                                            <input type="text" name="cidade" id="input-cidade" class="form-control form-control-alternative{{ $errors->has('cidade') ? ' is-invalid' : '' }}" placeholder="Cidade" required autofocus>
    
                                            @if ($errors->has('cidade'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('cidade') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-group{{ $errors->has('estado') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-estado">Estado *</label>
                                            <input type="text" name="estado" id="input-estado" maxlength="2" class="form-control form-control-alternative{{ $errors->has('estado') ? ' is-invalid' : '' }}" placeholder="Estado (Exemplo: SP)" required autofocus>
    
                                            @if ($errors->has('estado'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('estado') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">Cadastrar</button>
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
    <script src="/argon/js/jquery.mask.min.js"></script>
    <script>
        function buscarEndereco(cep) {
            if(cep.length > 7) {
                $.ajax({
                    url: 'https://viacep.com.br/ws/' + cep +'/json/',
                    dataType: 'json',
                    success: function(res) {
                        if(res.logradouro.length > 0) {
                            $('#input-endereco').val(res.logradouro)
                            $('#input-bairro').val(res.bairro)
                            $('#input-cidade').val(res.localidade)
                            $('#input-estado').val(res.uf)
                        }
                    },
                    error: function() {
                        console.log('API offline')
                    }
                })
            }
        }
    </script>
@endpush