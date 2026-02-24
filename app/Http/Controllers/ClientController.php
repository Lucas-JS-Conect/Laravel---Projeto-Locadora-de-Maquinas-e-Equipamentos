<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function list()
    {
        $clients = Client::all();
        return view('clients.list', compact('clients'));
    }

    public function create()
    {
        $users = User::all();
        return view('clients.create', compact('users'));
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:clients,email',
        'phone' => 'required|max:20',
        'cpf_cnpj' => 'required|unique:clients,cpf_cnpj',
        'gender' => 'required|in:male,female',
        'birth_date' => 'required|date',
        'address' => 'required|max:255',
        'occupation' => 'required|max:255',
        'user_id' => 'required|exists:users,id',
    ]);

    Client::create($request->all());

    return redirect('/clients')->with('success', 'Cliente cadastrado com sucesso!');
}

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        $users = User::all();
        return view('clients.edit', compact('client', 'users'));
    }

   public function update(Request $request, Client $client)
{
    $request->validate([
        'name' => 'required|max:255',
        'email' => [
            'required',
            'email',
            Rule::unique('clients')->ignore($client->id),
        ],
        'cpf_cnpj' => [
            'required',
            Rule::unique('clients')->ignore($client->id),
        ],
        'phone' => 'required|max:20',
        'birth_date' => 'required|date',
        'gender' => 'required|in:male,female',
        'address' => 'required|max:255',
        'occupation' => 'required|max:255',
        'user_id' => 'required|exists:users,id',
    ]);

    $client->update($request->all());

    return redirect()->route('clients.index')
        ->with('success', 'Cliente atualizado com sucesso!');
}

    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect('/clients')->with('success', 'Cliente deletado com sucesso!');
    }

    private function validateClientRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:clients,email,' . $request->id,
            'phone' => 'required|max:20',
            'cpf_cnpj' => 'required|unique:clients,cpf_cnpj,' . $request->id,
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'address' => 'required|max:255',
            'occupation' => 'required|max:255',
            'user_id' => 'required|exists:users,id',
        ]);
    }
}
