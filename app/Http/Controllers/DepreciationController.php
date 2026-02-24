<?php

namespace App\Http\Controllers;

use App\Models\Depreciation;
use App\Models\Machine;
use Illuminate\Http\Request;

class DepreciationController extends Controller
{
    public function index()
    {
        $depreciations = Depreciation::with('machine')->get();
        return view('depreciations.index', compact('depreciations'));
    }

    public function create()
    {
        $machines = Machine::all();
        return view('depreciations.create', compact('machines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'initial_value' => 'required|numeric|min:0',
            'residual_value' => 'required|numeric|min:0',
            'useful_life_years' => 'required|integer|min:1',
        ]);

        $depreciation_amount = ($request->initial_value - $request->residual_value) / $request->useful_life_years;

        $depreciation = new Depreciation();
        $depreciation->machine_id = $request->machine_id;
        $depreciation->initial_value = $request->initial_value;
        $depreciation->residual_value = $request->residual_value;
        $depreciation->useful_life_years = $request->useful_life_years;
        $depreciation->amount = $depreciation_amount;
        $depreciation->save();

        return redirect()->route('depreciations.index')->with('success', 'Depreciação criada com sucesso!');
    }

    public function show($id)
    {
        $depreciation = Depreciation::with('machine')->findOrFail($id);
        return view('depreciations.show', compact('depreciation'));
    }

    public function edit($id)
    {
        $depreciation = Depreciation::findOrFail($id);
        $machines = Machine::all();
        return view('depreciations.edit', compact('depreciation', 'machines'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'initial_value' => 'required|numeric|min:0',
            'residual_value' => 'required|numeric|min:0',
            'useful_life_years' => 'required|integer|min:1',
        ]);

        $depreciation_amount = ($request->initial_value - $request->residual_value) / $request->useful_life_years;

        $depreciation = Depreciation::findOrFail($id);
        $depreciation->machine_id = $request->machine_id;
        $depreciation->initial_value = $request->initial_value;
        $depreciation->residual_value = $request->residual_value;
        $depreciation->useful_life_years = $request->useful_life_years;
        $depreciation->amount = $depreciation_amount;
        $depreciation->save();

        return redirect()->route('depreciations.index')->with('success', 'Depreciação atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $depreciation = Depreciation::findOrFail($id);
        $depreciation->delete();

        return redirect()->route('depreciations.index')->with('success', 'Depreciação excluída com sucesso!');
    }
}