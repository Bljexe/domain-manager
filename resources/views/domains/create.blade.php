@extends('layouts.app')

@section('title', 'Adicionar Domínio')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">🌐 Adicionar Domínio</h2>
            <a href="{{ route('domains.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('domains.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="provider_id" class="form-label">Provedor</label>
                            <select class="form-select @error('provider_id') is-invalid @enderror" name="provider_id"
                                id="provider_id" required>
                                <option value="" selected disabled>Selecione um provedor</option>
                                @foreach ($providers as $provider)
                                    <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                            @error('provider_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="url" class="form-label">URL</label>
                            <input type="url" class="form-control @error('url') is-invalid @enderror" name="url"
                                id="url" placeholder="https://meusite.com" value="{{ old('url') }}" required>
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ip" class="form-label">Endereço IP</label>
                            <input type="text" class="form-control @error('ip') is-invalid @enderror" name="ip"
                                id="ip" placeholder="192.168.0.1" value="{{ old('ip') }}" required>
                            @error('ip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">SSL</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ssl" id="ssl_sim" value="1"
                                    checked>
                                <label class="form-check-label" for="ssl_sim"><i class="bi bi-lock-fill text-success"></i>
                                    Ativado</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ssl" id="ssl_nao" value="0">
                                <label class="form-check-label" for="ssl_nao"><i
                                        class="bi bi-exclamation-triangle text-danger"></i> Desativado</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" id="status"
                                required>
                                <option value="1" selected>Ativo</option>
                                <option value="0">Pendente</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Salvar Domínio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#url').on('input', function() {
                    let url = $(this).val();
                    let pattern = /^(https?:\/\/)?([\w\d\-_]+\.+[A-Za-z]{2,})+\/?/;
                    if (!pattern.test(url)) {
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
            });
        </script>
    @endpush
@endsection
