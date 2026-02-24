<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = $this->validateClientRequest($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $client = new Client($request->all());
        $client->save();

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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cpf_cnpj' => 'required|string|max:20',
            'phone' => 'required|string|max:15',
            'birth_date' => 'required|date',
            'gender' => 'required|string',
            'address' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
        ]);

        try {
            $client->update($request->all());
            return redirect()->route('clients.index')->with('success', 'Cliente atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('error', 'Erro ao atualizar o cliente: ' . $e->getMessage());
        }
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
