<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>

<body class="d-flex justify-content-center align-items-center vh-100"
    style="background: linear-gradient(135deg, #667eea, #764ba2);">
    <div class="container bg-white p-4 rounded shadow" style="max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <h3 class="text-center mb-4">Registro</h3>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="row">
                <!-- Dados Pessoais -->
                <div class="col-12 col-md-6 p-3 border rounded">
                    <h5 class="text-center">Dados Pessoais</h5>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required>

                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" required>

                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="document_type" class="form-label">Tipo de Documento</label>
                        <select class="form-control" id="document_type" name="document_type" required>
                            <option value="cpf">CPF</option>
                            <option value="cnpj">CNPJ</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="document_number" class="form-label">Número do Documento</label>
                        <input type="text" class="form-control" id="document_number" name="document_number" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                </div>

                <!-- Endereço -->
                <div class="col-12 col-md-6 p-3 border rounded mt-3 mt-md-0">
                    <h5 class="text-center">Endereço</h5>

                    <div class="mb-3">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep" required>
                    </div>

                    <div class="mb-3">
                        <label for="street" class="form-label">Rua</label>
                        <input type="text" class="form-control" id="street" name="street" required>
                    </div>

                    <div class="mb-3">
                        <label for="number" class="form-label">Número</label>
                        <input type="text" class="form-control" id="number" name="number" required>
                    </div>

                    <div class="mb-3">
                        <label for="complement" class="form-label">Complemento</label>
                        <input type="text" class="form-control" id="complement" name="complement">
                    </div>

                    <div class="mb-3">
                        <label for="neighborhood" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="neighborhood" name="neighborhood" required>
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>

                    <div class="mb-3">
                        <label for="state" class="form-label">Estado</label>
                        <input type="text" class="form-control" id="state" name="state" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Registrar</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $("#document_number").mask('000.000.000-00', {
                reverse: true
            });

            $("#document_type").change(function() {
                var docType = $(this).val();
                var docNumberField = $("#document_number");

                if (docType === "cpf") {
                    docNumberField.mask('000.000.000-00', {
                        reverse: true
                    });
                } else if (docType === "cnpj") {
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
</body>

</html>
