@extends('layouts.app')

@section('title', 'Editar Domínio')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold"><i class="bi bi-pencil-square"></i> Editar Domínio</h2>
            <a href="{{ route('domains.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('domains.edit', $domain->reference) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Provedor -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Provedor</label>
                            <select class="form-select" name="provider_id" required>
                                <option value="" disabled>Selecione um provedor</option>
                                @foreach ($providers as $provider)
                                    <option value="{{ $provider->id }}"
                                        {{ $domain->provider_id == $provider->id ? 'selected' : '' }}>
                                        {{ $provider->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- URL -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">URL</label>
                            <input type="url" name="url" class="form-control" value="{{ old('url', $domain->url) }}"
                                required>
                        </div>

                        <!-- Endereço IP -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Endereço IP</label>
                            <input type="text" name="ip" class="form-control ip-mask"
                                value="{{ old('ip', $domain->ip) }}" required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="1" {{ $domain->status ? 'selected' : '' }}>Ativo</option>
                                <option value="0" {{ !$domain->status ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>

                        <!-- SSL -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">SSL</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ssl" value="1" id="ssl-ativo"
                                    {{ $domain->ssl ? 'checked' : '' }}>
                                <label class="form-check-label" for="ssl-ativo">
                                    <i class="bi bi-lock-fill text-success"></i> Ativado
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ssl" value="0"
                                    id="ssl-inativo" {{ !$domain->ssl ? 'checked' : '' }}>
                                <label class="form-check-label" for="ssl-inativo">
                                    <i class="bi bi-exclamation-triangle text-danger"></i> Desativado
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Botão de Salvar -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Salvar Alterações
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Cleave('.ip-mask', {
                delimiter: '.',
                blocks: [3, 3, 3, 3],
                numericOnly: true
            });
        });
    </script>
@endpush
