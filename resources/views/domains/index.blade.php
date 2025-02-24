@extends('layouts.app')

@section('title', 'Meus Domínios')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">📡 Meus Domínios</h2>
            <a href="{{ route('domains.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Adicionar Domínio
            </a>
        </div>

        <!-- Cards de estatísticas -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <h5 class="fw-bold text-muted">Total de Domínios</h5>
                        <h3 class="fw-bold">{{ $totalDomains }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <h5 class="fw-bold text-success">Ativos</h5>
                        <h3 class="fw-bold">{{ $activeDomains }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <h5 class="fw-bold text-warning">Pendentes</h5>
                        <h3 class="fw-bold">{{ $pendingDomains }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Domínios -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table align-middle table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>URL</th>
                            <th>Provedor</th>
                            <th>IP</th>
                            <th>SSL</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($domains as $domain)
                            <tr>
                                <td>{{ $domain->reference }}</td>
                                <td><a href="{{ $domain->url }}">{{ $domain->url }}</a></td>
                                <td>{{ $domain->provider->name }}</td>
                                <td>{{ $domain->ip }}</td>
                                <td>
                                    <span class="badge bg-{{ $domain->ssl ? 'success' : 'danger' }}">
                                        <i class="bi bi-{{ $domain->ssl ? 'shield-lock-fill' : 'shield-slash-fill' }}"></i>
                                        {{ $domain->ssl ? 'Seguro' : 'Não Seguro' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $domain->status ? 'success' : 'warning' }}">
                                        {{ $domain->status ? 'Ativo' : 'Pendente' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <button class="btn btn-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('domains.edit', $domain->reference) }}">
                                                    <i class="bi bi-pencil-square me-2"></i>Editar
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('domains.destroy', $domain->reference) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i>Excluir
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $domains->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </div>
@endsection
