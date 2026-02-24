<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Machine;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\ScheduleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('machine', 'client')->get();
        return view('rentals.index', compact('rentals'));
    }

    public function create(Request $request)
    {
        $machines = Machine::where('status', 'disponível')->get();
        $clients = Client::all();
        return view('rentals.create', compact('machines', 'clients'));

        $machines = Machine::all()->filter(function ($machine) {
            return !$machine->isUnderMaintenance();
        });
    
        return view('rentals.create', compact('machines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'machine_id' => 'required|exists:machines,id',
            'hours_rented' => 'required|numeric|min:0.1',
        ]);

        $machine = Machine::findOrFail($request->machine_id);

        if (!$machine->isAvailableForRental()) {

            return redirect()->back()->with('error', 'A máquina selecionada não está disponível para aluguel no momento.');
        }
    
        $total_amount = $request->hours_rented * $machine->hourly_rate;
    
        $rental = Rental::create([
            'user_id' => auth()->id(),
            'client_id' => $request->client_id,
            'machine_id' => $request->machine_id,
            'start_date' => now(),
            'end_date' => now()->addHours($request->hours_rented), // Calcula a data de término baseada nas horas
            'hours_rented' => $request->hours_rented,
            'total_amount' => $total_amount,
            'paid' => false,
            'returned' => false,
        ]);

        $machine->update(['status' => 'Alugada']);

        return redirect()->route('rentals.index')->with('success', 'Locação criada com sucesso!');
    
    }

    public function show($id)
    {
        $rental = Rental::with('machine', 'client', 'payments')->findOrFail($id);
        return view('rentals.show', compact('rental'));
    }

    public function edit($id)
    {
        $rental = Rental::findOrFail($id);
        $machines = Machine::where('status', 'disponível')->get();
        $clients = Client::all();
        return view('rentals.edit', compact('rental', 'machines', 'clients'));
    }

    public function update(Request $request, $id)
{
    $rental = Rental::findOrFail($id);

    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'machine_id' => 'required|exists:machines,id',
        'hours_rented' => 'required|numeric|min:0.1',
    ]);

    $machine = Machine::findOrFail($request->machine_id);
    $total_amount = $request->hours_rented * $machine->hourly_rate;

    $rental->update([
        'client_id' => $request->client_id,
        'machine_id' => $request->machine_id,
        'hours_rented' => $request->hours_rented,
        'end_date' => now()->addHours($request->hours_rented), 
        'total_amount' => $total_amount,
        'paid' => $request->input('paid', $rental->paid),
        'returned' => $request->input('returned', $rental->returned),
    ]);

    return redirect()->route('rentals.index')->with('success', 'Locação atualizada com sucesso!');
}
    public function destroy($id)
    {
        $rental = Rental::findOrFail($id);
        $rental->delete();

        return redirect()->route('rentals.index')->with('success', 'Locação deletada com sucesso!');
    }

    public function requestSchedule($machine_id)
    {
        $machine = Machine::findOrFail($machine_id);
        return view('rentals.request_schedule', compact('machine'));
    }

    public function submitScheduleRequest(Request $request)
    {
        $request->validate([
            'machine_type' => 'required',
            'requested_date' => 'required|date',
        ]);

        $scheduleRequest = new ScheduleRequest([
            'machine_type' => $request->machine_type,
            'requested_date' => $request->requested_date,
            'comments' => $request->comments,
        ]);

        $scheduleRequest->save();

        return redirect()->route('rentals.index')->with('success', 'Solicitação de agendamento enviada com sucesso!');
    }

    public function return($id)
    {
        $rental = Rental::findOrFail($id);
        $rental->returned = true;
        $rental->save();

        $machine = Machine::find($rental->machine_id);
        $machine->status = 'disponível';
        $machine->save();

        return redirect()->route('rentals.index')->with('success', 'Máquina devolvida com sucesso!');
    }

    public function markPayment(Request $request, $id)
{
    $rental = Rental::findOrFail($id);
    $rental->paid = $request->input('paid');
    $rental->save();

    // Inserir no banco de dados de pagamentos
    Payment::create([
        'rental_id' => $rental->id,
        'client_id' => $rental->client_id,
        'amount' => $rental->total_amount,
        'paid' => $rental->paid,
    ]);

    return redirect()->route('rentals.index')->with('success', 'Status de pagamento atualizado com sucesso!');
}
}
