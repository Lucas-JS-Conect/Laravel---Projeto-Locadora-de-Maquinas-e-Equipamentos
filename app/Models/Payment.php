<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'amount',
        'status',
        'paid_at'
    ];

    protected $dates = ['paid_at'];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function generateReport()
    {
        // Data de 1 ano atrás a partir de hoje
        $startDate = Carbon::now()->subDays(365);

        // Data de hoje
        $endDate = Carbon::now();

        // Busca por pagamentos no intervalo de datas
        $payments = Payment::whereBetween('created_at', [$startDate, $endDate])
            ->select('id', 'amount', 'status', 'created_at')
            ->get();

        return view('reports.payment_report', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'payments' => $payments
        ]);
    }
}
