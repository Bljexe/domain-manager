<?php

namespace App\Http\Controllers\Domains;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    public function index()
    {
        $domains = Domain::where('user_id', auth()->id())
            ->with('provider')
            ->paginate(10);

        return view('domains.index', [
            'domains' => $domains,
            'totalDomains' => $domains->total(),
            'activeDomains' => $domains->filter(fn($d) => $d->status)->count(),
            'pendingDomains' => $domains->filter(fn($d) => !$d->status)->count(),
        ]);
    }

    public function create()
    {
        $providers = Provider::where('status', true)->orderBy('name')->get();
        return view('domains.create', compact('providers'));
    }

    public function edit($id)
    {
        $domain = Domain::where('user_id', Auth::id())->where('reference', $id)->firstOrFail();
        $providers = Provider::orderBy('name')->get();

        return view('domains.edit', compact('domain', 'providers'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'url' => 'required|url',
                'ip' => 'required',
                'ssl' => 'required|boolean',
                'status' => 'required|boolean',
                'provider_id' => 'required|exists:providers,id',
            ],
            [
                'provider_id.exists' => 'O provedor selecionado é inválido.',
                'provider_id.required' => 'O campo provedor é obrigatório.',
                'status.required' => 'O campo status é obrigatório.',
                'ssl.required' => 'O campo SSL é obrigatório.',
                'ip.required' => 'O campo IP é obrigatório.',
                'url.required' => 'O campo URL é obrigatório.',
                'url.url' => 'O campo URL deve ser uma URL válida.',
            ],
        );

        Domain::create([
            'user_id' => Auth::id(),
            'provider_id' => $request->provider_id,
            'reference' => uniqid(),
            'url' => $request->url,
            'ip' => $request->ip,
            'ssl' => $request->ssl,
            'status' => $request->status,
        ]);

        return redirect()->route('domains.index')->with('success', 'Domínio cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $domain = Domain::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'reference' => 'required|string|max:255',
            'url' => 'required|url',
            'ip' => 'required|ip',
            'ssl' => 'required|boolean',
            'status' => 'required|boolean',
            'provider_id' => 'required|exists:providers,id',
        ]);

        $domain->update([
            'provider_id' => $request->provider_id,
            'reference' => $request->reference,
            'url' => $request->url,
            'ip' => $request->ip,
            'ssl' => $request->ssl,
            'status' => $request->status,
        ]);

        return redirect()->route('domains.index')->with('success', 'Domínio atualizado com sucesso!');
    }

    public function delete($id)
    {
        if (!Domain::where('user_id', Auth::id())->where('reference', $id)->exists()) {
            return redirect()->route('domains.index')->with('error', 'Domínio não encontrado.');
        }

        $domain = Domain::where('user_id', Auth::id())->where('reference', $id)->firstOrFail();
        $domain->delete();

        return redirect()->route('domains.index')->with('success', 'Domínio excluído com sucesso!');
    }
}
