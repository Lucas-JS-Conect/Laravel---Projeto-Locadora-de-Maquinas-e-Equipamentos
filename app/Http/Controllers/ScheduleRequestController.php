<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Machine;
use App\Models\ScheduleRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleRequestController extends Controller
{


    public function index()
    {
        $scheduleRequests = ScheduleRequest::with('machine', 'client')->get();

        return view('schedule_requests.index', compact('scheduleRequests'));
    }

    public function create()
    {
        $machines = Machine::all();
        $requested_date = now();
        $clients = Client::all();
        return view('schedule_requests.create', compact('machines', 'clients'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required',
            'machine_id' => 'required',
            'requested_date' => 'required|date',
            'comments' => 'nullable|string',
        ]);

        ScheduleRequest::create($validatedData);

        return redirect()->route('schedule_requests.index')->with('success', 'Solicitação de agendamento criada com sucesso.');
    }

    public function edit(ScheduleRequest $scheduleRequest)
    {
        $machines = Machine::all();
        $clients = Client::all();
        return view('schedule_requests.edit', compact('scheduleRequest', 'machines', 'clients'));
    }

    public function update(Request $request, ScheduleRequest $scheduleRequest)
    {
        $validatedData = $request->validate([
            'client_id' => 'required',
            'machine_id' => 'required',
            'requested_date' => 'required|date',
            'comments' => 'nullable|string',
        ]);

        $scheduleRequest->update($validatedData);

        return redirect()->route('schedule_requests.index')->with('success', 'Solicitação de agendamento atualizada com sucesso.');
    }

    public function destroy(ScheduleRequest $scheduleRequest)
    {
        $scheduleRequest->delete();

        return redirect()->route('schedule_requests.index')->with('success', 'Solicitação de agendamento excluída com sucesso.');
    }

    public function show( $id)
    {
        $scheduleRequest = ScheduleRequest::findOrFail($id);

        return view('schedule_requests.show', compact('scheduleRequest'));
    }

    public function finish($id)
    {
        $scheduleRequest = ScheduleRequest::findOrFail($id);

        $scheduleRequest->update([
            'status' => 'Finalizado'
        ]);

        return redirect()->route('schedule_requests.show', $scheduleRequest->id)
            ->with('success', 'Solicitação de agendamento finalizada com sucesso!');
    }

    public function complete($id)
    {
        $scheduleRequest = ScheduleRequest::findOrFail($id);

        if ($scheduleRequest->status == 'Finalizado') {
            return redirect()->back()->with('error', 'Esta solicitação já está finalizada.');
        }

        $scheduleRequest->update(['status' => 'Finalizado']);

        return redirect()->back()->with('success', 'Solicitação finalizada com sucesso.');
    }
}
