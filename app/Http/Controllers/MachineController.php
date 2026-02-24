<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\User;
use Illuminate\Http\Request;


class MachineController extends Controller
{
    public function index()
    {

        $search = request('search');

        if ($search) {
            $machines = Machine::where('name', 'like', '%' . $search . '%')->get();
        } else {
            $machines = Machine::all();
        }

        return view('welcome', ['machines' => $machines, 'search' => $search]);
    }

    public function create()
    {
        return view('machines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'model' => 'required|string',
            'brand' => 'required|string',
            'manufacture_year' => 'required|integer',
            'acquisition_year' => 'required|integer',
            'serial_number' => 'required|string|unique:machines,serial_number',
            'hourly_rate' => 'required|numeric', // Validar o campo hourly_rate
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $machine = new Machine([
            'name' => $request->name,
            'type' => $request->type,
            'model' => $request->model,
            'brand' => $request->brand,
            'manufacture_year' => $request->manufacture_year,
            'acquisition_year' => $request->acquisition_year,
            'serial_number' => $request->serial_number,
            'hourly_rate' => $request->hourly_rate, // Inserir hourly_rate fornecido pelo usuário
        ]);

        // Image Upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . '.' . $extension;
            $requestImage->move(public_path('img/machine'), $imageName);
            $machine->image = $imageName;
        }

        $user = auth()->user();
        $machine->user_id = $user->id;

        $machine->save();

        return redirect('/')->with('msg', 'Cadastro de máquina efetuado com sucesso!');
    }

    public function show($id)
    {
        $machine = Machine::findOrFail($id);
        $user = auth()->user();
        $hasUserJoined = false;

        if ($user) {
            // Obtém as máquinas agendadas do usuário ou inicializa como uma coleção vazia
            $userMachines = $user->machinesAsScheduling ?? collect();

            // Verifica se a máquina atual está entre as máquinas agendadas do usuário
            if ($userMachines->contains($machine)) {
                $hasUserJoined = true;
            }
        }

        // Retorna a view com os dados da máquina e a informação se o usuário já agendou
        return view('machines.show', [
            'machine' => $machine,
            'hasUserJoined' => $hasUserJoined,
        ]);
    }
    public function dashboard()
    {
        $machines = Machine::all();
        return view('machines.dashboard', compact('machines'));
    }

    public function destroy($id)
    {
        Machine::findOrFail($id)->delete();
        return redirect('/dashboard')->with('msg', 'Máquina excluída com sucesso!');
    }

    public function edit($id)
    {
        $user = auth()->user();
        $machine = Machine::findOrFail($id);

        if ($user->id != $machine->user_id) {
            return redirect('/dashboard');
        }

        return view('machines.edit', ['machine' => $machine]);
    }

    public function update(Request $request, $id)
    {
        $machine = Machine::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'model' => 'required',
            'brand' => 'required',
            'manufacture_year' => 'required|integer',
            'acquisition_year' => 'required|integer',
            'serial_number' => 'required',
            'hourly_rate' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $machine->name = $request->name;
        $machine->type = $request->type;
        $machine->model = $request->model;
        $machine->brand = $request->brand;
        $machine->manufacture_year = $request->manufacture_year;
        $machine->acquisition_year = $request->acquisition_year;
        $machine->serial_number = $request->serial_number;
        $machine->hourly_rate = $request->hourly_rate;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('machine_images', 'public');
            $machine->image = $imagePath;
        }

        $machine->save();

        return redirect()->route('machines.dashboard')->with('success', 'Máquina atualizada com sucesso!');
    }
}
