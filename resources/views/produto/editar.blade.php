@extends('layouts.app', ['title' => 'Editar produto'])

@section('content')
    @include('users.partials.header', [
        'title' => $produto->nome,
        'description' => $produto->descricao,
        'class' => 'col-lg-7'
    ])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-10 mx-auto order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">Editar Produto</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('produto.update', $produto->produto_id) }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">Informações do produto</h6>
                            
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">Nome do produto</label>
                                    <input type="text" name="nome" id="input-name" class="form-control form-control-alternative{{ $errors->has('nome') ? ' is-invalid' : '' }}" placeholder="Nome do produto" value="{{ old('name', $produto->nome) }}" required autofocus>

                                    @if ($errors->has('nome'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nome') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('valor') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-valor">Valor do produto</label>
                                    <div class="input-group input-group-alternative mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" name="valor" id="input-valor" data-mask="000.000.000.000.000,00" data-mask-reverse="true" class="form-control form-control-alternative{{ $errors->has('valor') ? ' is-invalid' : '' }}" placeholder="Valor do produto" value="{{ old('valor', number_format($produto->valor, 2, ',', '.')) }}" required autofocus>
                                    </div>

                                    @if ($errors->has('valor'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('valor') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('descricao') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">Descrição do produto</label>
                                    <textarea name="descricao" id="input-desc" class="form-control form-control-alternative{{ $errors->has('descricao') ? ' is-invalid' : '' }}" placeholder="Descrição do produto">{{ old('descricao', $produto->descricao) }}</textarea>

                                    @if ($errors->has('descricao'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('descricao') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">Atualizar</button>
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
@endpush