<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Machine;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('machine')->get();
        return view('maintenances.index', compact('maintenances'));
    }

    public function create()
    {
        $machines = Machine::whereNotIn('status', ['Em Manutenção', 'Alugada'])->get();
        return view('maintenances.create', compact('machines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'required|string',
        ]);

        $machine = Machine::find($request->machine_id);

        if (!$machine) {
            return redirect()->back()->with('error', 'Máquina não encontrada.');
        }

        if (!$machine->isAvailableForRental()) {
            return redirect()->back()->with('error', 'Não é possível registrar manutenção. Máquina está alugada ou em manutenção.');
        }

        $maintenance = new Maintenance([
            'machine_id' => $request->machine_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
        ]);

        $maintenance->save();

        $machine->startMaintenance();

        return redirect()->route('maintenances.index')->with('success', 'Manutenção registrada com sucesso!');
    }
    public function edit(Maintenance $maintenance)
    {
        $machines = Machine::whereNotIn('status', ['Em Manutenção', 'Alugada'])->get();
        return view('maintenances.edit', compact('maintenance', 'machines'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'required|string',
        ]);

        $machine = Machine::find($request->machine_id);

        if (!$machine) {
            return redirect()->back()->with('error', 'Máquina não encontrada.');
        }

        if (!$machine->isAvailableForMaintenance()) {
            return redirect()->back()->with('error', 'Não é possível atualizar manutenção. Máquina está alugada ou em manutenção.');
        }

        $maintenance->machine_id = $request->machine_id;
        $maintenance->start_date = $request->start_date;
        $maintenance->end_date = $request->end_date;
        $maintenance->description = $request->description;

        $maintenance->save();

        return redirect()->route('maintenances.index')->with('success', 'Manutenção atualizada com sucesso!');
    }

    public function destroy(Maintenance $maintenance)
    {
        $machine = $maintenance->machine;

        if ($machine) {
            $machine->endMaintenance();
        }

        $maintenance->delete();

        return redirect()->route('maintenances.index')->with('success', 'Manutenção excluída com sucesso!');
    }

    public function finish(Request $request, Maintenance $maintenance)
    {
        $request->validate([
            'end_date' => 'required|date|after_or_equal:' . $maintenance->start_date,
        ]);

        $maintenance->end_date = $request->end_date;
        $maintenance->is_finished = true;
        $maintenance->save();

        $machine = $maintenance->machine;

        if ($machine) {
            $machine->endMaintenance(); 
        }

        return redirect()->route('maintenances.index')->with('success', 'Manutenção finalizada com sucesso!');
    }


    public function show(Maintenance $maintenance)
    {
        return view('maintenances.show', compact('maintenance'));
    }
}
