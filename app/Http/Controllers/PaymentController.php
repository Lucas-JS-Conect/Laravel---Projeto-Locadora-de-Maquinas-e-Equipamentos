<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rental;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('rental.client', 'rental.machine')->get();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $rentals = Rental::where('paid', false)->get();
        return view('payments.create', compact('rentals'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'nullable|date',
        ]);

        Payment::create($validatedData);

        // Atualizar o status de pagamento do aluguel
        $rental = Rental::find($validatedData['rental_id']);
        $rental->update(['paid' => true]);

        return redirect()->route('payments.index')->with('success', 'Pagamento registrado com sucesso.');
    }

    public function show(Payment $payment)
    {
        $payment->load('rental.client', 'rental.machine');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $rentals = Rental::where('paid', false)->get();
        return view('payments.edit', compact('payment', 'rentals'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validatedData = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'nullable|date',
        ]);

        $payment->update($validatedData);

        // Atualizar o status de pagamento do aluguel se necessário
        $rental = Rental::find($validatedData['rental_id']);
        if (!$rental->paid) {
            $rental->update(['paid' => true]);
        }

        return redirect()->route('payments.index')->with('success', 'Pagamento atualizado com sucesso.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        // Verificar se há outros pagamentos pendentes para atualizar o status do aluguel
        $rental = $payment->rental;
        if (!$rental->payments()->exists()) {
            $rental->update(['paid' => false]);
        }

        return redirect()->route('payments.index')->with('success', 'Pagamento excluído com sucesso.');
    }
}
