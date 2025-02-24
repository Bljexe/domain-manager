<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Exibe a página de perfil do usuário.
     */
    public function index()
    {
        return view('profile.index');
    }

    /**
     * Atualiza os dados pessoais do usuário.
     */
    public function updateProfile(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
                'document_type' => 'required|string|in:CPF,CNPJ',
                'document_number' => ['required', 'string', 'max:20', 'unique:users,document_number,' . auth()->id(), $request->document_type === 'CPF' ? 'cpf' : 'cnpj'],
                'phone' => 'required|string|max:15',
            ],
            [
                'name.required' => 'O campo nome é obrigatório.',
                'name.string' => 'O campo nome deve ser uma string.',
                'name.max' => 'O campo nome não pode ter mais que 255 caracteres.',
                'email.required' => 'O campo email é obrigatório.',
                'email.string' => 'O campo email deve ser uma string.',
                'email.email' => 'O campo email deve ser um endereço de email válido.',
                'email.max' => 'O campo email não pode ter mais que 255 caracteres.',
                'email.unique' => 'O email informado já está em uso.',
                'document_type.required' => 'O campo tipo de documento é obrigatório.',
                'document_type.string' => 'O campo tipo de documento deve ser uma string.',
                'document_type.in' => 'O campo tipo de documento deve ser CPF ou CNPJ.',
                'document_number.required' => 'O campo número do documento é obrigatório.',
                'document_number.string' => 'O campo número do documento deve ser uma string.',
                'document_number.max' => 'O campo número do documento não pode ter mais que 20 caracteres.',
                'document_number.unique' => 'O número do documento informado já está em uso.',
                'phone.required' => 'O campo telefone é obrigatório.',
                'phone.string' => 'O campo telefone deve ser uma string.',
                'phone.max' => 'O campo telefone não pode ter mais que 15 caracteres.',
            ],
        );

        $user = User::find(auth()->id());
        $user->update($request->only(['name', 'document_type', 'document_number', 'phone']));

        return back()->with('success', 'Dados pessoais atualizados com sucesso!');
    }

    /**
     * Atualiza o endereço do usuário.
     */
    public function updateAddress(Request $request)
    {
        $request->validate(
            [
                'cep' => 'required',
                'street' => 'required|string|max:255',
                'number' => 'required|string|max:10',
                'complement' => 'nullable|string|max:255',
                'neighborhood' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:2',
            ],
            [
                'cep.required' => 'O campo CEP é obrigatório.',
                'street.required' => 'O campo rua é obrigatório.',
                'street.string' => 'O campo rua deve ser uma string.',
                'street.max' => 'O campo rua não pode ter mais que 255 caracteres.',
                'number.required' => 'O campo número é obrigatório.',
                'number.string' => 'O campo número deve ser uma string.',
                'number.max' => 'O campo número não pode ter mais que 10 caracteres.',
                'complement.string' => 'O campo complemento deve ser uma string.',
                'complement.max' => 'O campo complemento não pode ter mais que 255 caracteres.',
                'neighborhood.required' => 'O campo bairro é obrigatório.',
                'neighborhood.string' => 'O campo bairro deve ser uma string.',
                'neighborhood.max' => 'O campo bairro não pode ter mais que 255 caracteres.',
                'city.required' => 'O campo cidade é obrigatório.',
                'city.string' => 'O campo cidade deve ser uma string.',
                'city.max' => 'O campo cidade não pode ter mais que 255 caracteres.',
                'state.required' => 'O campo estado é obrigatório.',
                'state.string' => 'O campo estado deve ser uma string.',
                'state.max' => 'O campo estado não pode ter mais que 2 caracteres.',
            ],
        );

        $user = User::find(auth()->id());

        $address = $user->address ?? new Address(['user_id' => $user->id]);
        $address->fill($request->all());
        $address->save();

        return back()->with('success', 'Endereço atualizado com sucesso!');
    }

    /**
     * Atualiza a senha do usuário.
     */
    public function updatePassword(Request $request)
    {
        $request->validate(
            [
                'current_password' => 'required',
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'current_password.required' => 'O campo senha atual é obrigatório.',
                'password.required' => 'O campo nova senha é obrigatório.',
                'password.confirmed' => 'A confirmação da nova senha não confere.',
                'password.string' => 'O campo nova senha deve ser uma string.',
                'password.min' => 'O campo nova senha deve ter no mínimo 8 caracteres.',
            ],
        );

        $user = User::find(auth()->id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'A senha atual está incorreta.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Senha atualizada com sucesso!');
    }
}
