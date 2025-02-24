@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white text-center fw-bold">
                        <i class="bi bi-person-circle"></i> Meu Perfil
                    </div>
                    <div class="card-body p-4">
                        <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="user-tab" data-bs-toggle="tab" data-bs-target="#user"
                                    type="button" role="tab">Dados Pessoais</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address"
                                    type="button" role="tab">Endereço</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security"
                                    type="button" role="tab">Segurança</button>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="profileTabsContent">
                            <!-- Dados Pessoais -->
                            <div class="tab-pane fade show active" id="user" role="tabpanel">
                                <form method="POST" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Nome</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ auth()->user()->name }}" required>

                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">E-mail</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ auth()->user()->email }}" required>

                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tipo de Documento</label>
                                        <select class="form-select" name="document_type" id="document_type" required>
                                            <option value="CPF"
                                                {{ auth()->user()->document_type == 'CPF' ? 'selected' : '' }}>CPF</option>
                                            <option value="CNPJ"
                                                {{ auth()->user()->document_type == 'CNPJ' ? 'selected' : '' }}>CNPJ
                                            </option>
                                        </select>

                                        @error('document_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Número do Documento</label>
                                        <input type="text" class="form-control" name="document_number"
                                            id="document_number" value="{{ auth()->user()->document_number }}" required>

                                        @error('document_number')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Telefone</label>
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ auth()->user()->phone }}">

                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Salvar Alterações</button>
                                </form>
                            </div>
                            <!-- Endereço -->
                            <div class="tab-pane fade" id="address" role="tabpanel">
                                <form method="POST" action="{{ route('profile.address.update') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">CEP</label>
                                        <input type="text" class="form-control" name="cep" id="cep"
                                            value="{{ auth()->user()->address->cep ?? '' }}" required>

                                        @error('cep')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Rua</label>
                                        <input type="text" class="form-control" name="street" id="street"
                                            value="{{ auth()->user()->address->street ?? '' }}" required>

                                        @error('street')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Número</label>
                                        <input type="text" class="form-control" name="number" id="number"
                                            value="{{ auth()->user()->address->number ?? '' }}" required>

                                        @error('number')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Complemento</label>
                                        <input type="text" class="form-control" name="complement" id="complement"
                                            value="{{ auth()->user()->address->complement ?? '' }}">

                                        @error('complement')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Bairro</label>
                                        <input type="text" class="form-control" name="neighborhood" id="neighborhood"
                                            value="{{ auth()->user()->address->neighborhood ?? '' }}" required>

                                        @error('neighborhood')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Cidade</label>
                                        <input type="text" class="form-control" name="city" id="city"
                                            value="{{ auth()->user()->address->city ?? '' }}" required>

                                        @error('city')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <input type="text" class="form-control" name="state" id="state"
                                            value="{{ auth()->user()->address->state ?? '' }}" required>

                                        @error('state')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Salvar Endereço</button>
                                </form>
                            </div>
                            <!-- Segurança -->
                            <div class="tab-pane fade" id="security" role="tabpanel">
                                <form method="POST" action="{{ route('profile.password.update') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Senha Atual</label>
                                        <input type="password" class="form-control" name="current_password" required>

                                        @error('current_password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nova Senha</label>
                                        <input type="password" class="form-control" name="password" required>

                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirme a Nova Senha</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            required>

                                        @error('password_confirmation')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Alterar Senha</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#document_number").mask('000.000.000-00', {
                reverse: true
            });

            $("#document_type").change(function() {
                var docType = $(this).val();
                var docNumberField = $("#document_number");

                if (docType === "CPF") {
                    docNumberField.mask('000.000.000-00', {
                        reverse: true
                    });
                } else if (docType === "CNPJ") {
                    docNumberField.mask('00.000.000/0000-00', {
                        reverse: true
                    });
                }
            });

            $('#phone').mask('(00) 00000-0000');
            $('#cep').mask('00000-000');

            $('#cep').on('blur', function() {
                var cep = $(this).val().replace(/\D/g, '');
                if (cep.length === 8) {
                    $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                        if (!data.erro) {
                            $('#street').val(data.logradouro);
                            $('#neighborhood').val(data.bairro);
                            $('#city').val(data.localidade);
                            $('#state').val(data.uf);
                        }
                    });
                }
            });
        });
    </script>
@endpush
