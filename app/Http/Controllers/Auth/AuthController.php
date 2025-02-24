<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->status === 0) {
            return redirect('/login')->with('error', 'Conta de usuário desativada.');
        }

        if ($user && Auth::attempt($credentials)) {
            Auth::login($user);
            session()->flash('success', 'Autenticado com sucesso!');

            return redirect('/');
        }

        return redirect('/login')->with('error', 'E-mail ou senha incorretos.');
    }

    public function register(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'document_type' => 'required|in:cpf,cnpj',
                'document_number' => ['required', $request->document_type === 'cpf' ? 'cpf' : 'cnpj', 'unique:users,document_number'],
                'phone' => 'required|min:10',
                'cep' => 'required',
                'street' => 'required|string|max:255',
                'number' => 'required|string|max:10',
                'complement' => 'nullable|string|max:255',
                'neighborhood' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:2',
            ],
            [
                'name.required' => 'O campo nome é obrigatório.',
                'email.required' => 'O campo e-mail é obrigatório.',
                'email.email' => 'O e-mail informado não é válido.',
                'email.unique' => 'O e-mail informado já está em uso.',
                'password.required' => 'O campo senha é obrigatório.',
                'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
                'password.confirmed' => 'As senhas informadas não são iguais.',
                'password_confirmation.required' => 'O campo confirmação de senha é obrigatório.',
                'password_confirmation.min' => 'A confirmação de senha deve ter no mínimo 8 caracteres.',
                'password_confirmation.confirmed' => 'As senhas informadas não são iguais.',
                'document_type.required' => 'O campo tipo de documento é obrigatório.',
                'document_type.in' => 'O tipo de documento informado não é válido.',
                'document_number.required' => 'O campo número do documento é obrigatório.',
                'document_number.cpf' => 'O CPF informado não é válido.',
                'document_number.cnpj' => 'O CNPJ informado não é válido.',
                'document_number.unique' => 'O número do documento informado já está em uso.',
                'phone.required' => 'O campo telefone é obrigatório.',
                'phone.min' => 'O telefone informado não é válido.',
                'cep.required' => 'O campo CEP é obrigatório.',
                'street.required' => 'O campo rua é obrigatório.',
                'number.required' => 'O campo número é obrigatório.',
                'complement.string' => 'O campo complemento deve ser uma string.',
                'complement.max' => 'O campo complemento deve ter no máximo 255 caracteres.',
                'neighborhood.required' => 'O campo bairro é obrigatório.',
                'city.required' => 'O campo cidade é obrigatório.',
                'state.required' => 'O campo estado é obrigatório.',
            ],
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'phone' => $request->phone,
        ]);

        Address::create([
            'user_id' => $user->id,
            'cep' => $request->cep,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
            'neighborhood' => $request->neighborhood,
            'city' => $request->city,
            'state' => $request->state,
        ]);

        //TODO: Enviar e-mail de boas-vindas, descomentar o código quando o servidor de e-mail estiver configurado
        // Mail::send('emails.welcome', ['user' => $user], function ($message) use ($user) {
        //     $message->to($user->email, $user->name)->subject('Bem-vindo!');
        // });

        session()->flash('success', 'Cadastro realizado com sucesso!');
        return redirect('/login');
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('success', 'Deslogado com sucesso!');

        return redirect('/login');
    }
}
