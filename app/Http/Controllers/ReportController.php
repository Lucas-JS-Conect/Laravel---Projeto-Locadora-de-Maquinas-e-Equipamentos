<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Depreciation;
use App\Models\Machine;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Rental;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'report_type' => 'required|string|in:client,machine,rental,depreciation'
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $reportType = $request->input('report_type');

        switch ($reportType) {
            case 'client':
                $clients = Client::with(['rentals' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate]);
                }, 'rentals.payments'])->get();
                return view('reports.client', compact('clients', 'startDate', 'endDate'));

            case 'machine':
                $machines = Machine::with(['depreciations' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }, 'maintenances' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate]);
                }, 'rentals' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate]);
                }, 'rentals.client'])->get();
                return view('reports.machine', compact('machines', 'startDate', 'endDate'));

            case 'rental':
                $rentals = Rental::with('user', 'client', 'machine')->whereBetween('start_date', [$startDate, $endDate])->get();
                return view('reports.rental', compact('rentals', 'startDate', 'endDate'));

            case 'depreciation':
                $depreciations = Depreciation::with('machine')->whereBetween('date', [$startDate, $endDate])->get();
                return view('reports.depreciation', compact('depreciations', 'startDate', 'endDate'));
        }
    }
}