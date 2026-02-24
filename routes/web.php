<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\LogginController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\DepreciationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ScheduleRequestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Auth::routes();



Route::middleware(['auth'])->group(function () {


    // Rotas para Máquinas 
    Route::resource('machines', MachineController::class);
    Route::get('/', [MachineController::class, 'index']);
    Route::get('/machines/create', [MachineController::class, 'create'])->name('machines.create');
    Route::post('/machines', [MachineController::class, 'store']);
    Route::get('/machines/{id}', [MachineController::class, 'show']);
    Route::get('/machines/edit/{id}', [MachineController::class, 'edit']);
    Route::put('/machines/{machine}', [MachineController::class, 'update'])->name('machines.update');
    Route::delete('/machines/{id}', [MachineController::class, 'destroy']);
    Route::get('/dashboard', [MachineController::class, 'dashboard'])->name('machines.dashboard');
    Route::post('/machines/join/{id}', [MachineController::class, 'joinMachine']);
    Route::delete('/machines/leave/{id}', [MachineController::class, 'leaveMachine']);

    // Rotas para Clientes
    Route::resource('clients', ClientController::class);
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
    Route::get('/clients/edit/{id}', [ClientController::class, 'edit']);
    Route::put('/clients/update/{id}', [ClientController::class, 'update']);
    Route::delete('/clients/{id}', [ClientController::class, 'destroy']);
    Route::get('/client/list', [ClientController::class, 'list']);
    Route::post('/clients/join/{id}', [ClientController::class, 'joinClient'])->name('clients.join');
    Route::post('/clients/leave/{id}', [ClientController::class, 'leaveClient'])->name('clients.leave');


    // Rotas para Usuários
    Route::resource('users', LogginController::class);
    Route::get('/user', [LogginController::class, 'index'])->name('user.index');
    Route::get('/user/{id}/editar', [LogginController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}/editar', [LogginController::class, 'update'])->name('user.update');
    Route::get('/user/novo', [LogginController::class, 'create'])->name('user.create');
    Route::post('/user/novo', [LogginController::class, 'store'])->name('user.store');
    Route::delete('/user/{id}', [LogginController::class, 'destroy'])->name('user.destroy');

    // Rotas para Aluguéis
    Route::resource('rentals', RentalController::class);
    Route::resource('rentals', RentalController::class)->except(['show']);
    Route::post('rentals/{rental}/mark-payment', [RentalController::class, 'markPayment'])->name('rentals.markPayment');
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/create', [RentalController::class, 'create'])->name('rentals.create');
    Route::post('/rentals', [RentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/request_schedule/{machine_id}', [RentalController::class, 'requestSchedule'])->name('rentals.request_schedule');
    Route::post('/rentals/submit_schedule_request', [RentalController::class, 'submitScheduleRequest'])->name('rentals.submit_schedule_request');
    Route::post('/rentals/{rental}/return', [RentalController::class, 'return'])->name('rentals.return');

    //Rotas para Pagamentos
    Route::resource('payments', PaymentController::class);

    //Rotas para Agendamentos
    Route::resource('schedule_requests', ScheduleRequestController::class);
    Route::get('/schedule_requests', [ScheduleRequestController::class, 'index'])->name('schedule_requests.index');
    Route::put('/schedule_requests/{scheduleRequest}/complete', [ScheduleRequestController::class, 'complete'])->name('schedule_requests.complete');
    Route::put('/schedule-requests/{id}/finish', [ScheduleRequestController::class, 'finish'])->name('schedule_requests.finish');
    Route::get('/schedule_requests/create', [ScheduleRequestController::class, 'create'])->name('schedule_requests.create');
    Route::post('/schedule_requests', [ScheduleRequestController::class, 'store'])->name('schedule_requests.store');
    Route::get('/schedule_requests/{scheduleRequest}', [ScheduleRequestController::class, 'show'])->name('schedule_requests.show');
    Route::get('/schedule_requests/{scheduleRequest}/edit', [ScheduleRequestController::class, 'edit'])->name('schedule_requests.edit');
    Route::put('/schedule_requests/{scheduleRequest}', [ScheduleRequestController::class, 'update'])->name('schedule_requests.update');
    Route::delete('/schedule_requests/{scheduleRequest}', [ScheduleRequestController::class, 'destroy'])->name('schedule_requests.destroy');

    // Rotas para Manutenções
    Route::resource('maintenances', MaintenanceController::class);
    Route::resource('maintenances', MaintenanceController::class)->except(['show']);
    Route::get('/maintenances', [MaintenanceController::class, 'index'])->name('maintenances.index');
    Route::get('/maintenances/create', [MaintenanceController::class, 'create'])->name('maintenances.create');
    Route::get('/maintenances/{maintenance}', [MaintenanceController::class, 'show'])->name('maintenances.show');
    Route::post('/maintenances', [MaintenanceController::class, 'store'])->name('maintenances.store');
    Route::get('/maintenances/{maintenance}/edit', [MaintenanceController::class, 'edit'])->name('maintenances.edit');
    Route::put('/maintenances/{maintenance}', [MaintenanceController::class, 'update'])->name('maintenances.update');
    Route::delete('/maintenances/{maintenance}', [MaintenanceController::class, 'destroy'])->name('maintenances.destroy');
    Route::put('/maintenances/{maintenance}/finish', [MaintenanceController::class, 'finish'])->name('maintenances.finish');

    // Rotas para Depreciações
    Route::resource('depreciations', DepreciationController::class);
    Route::get('/depreciations', [DepreciationController::class, 'index'])->name('depreciations.index');
    Route::get('/depreciations/create', [DepreciationController::class, 'create'])->name('depreciations.create');
    Route::post('/depreciations', [DepreciationController::class, 'store'])->name('depreciations.store');
    Route::get('/depreciations/{id}', [DepreciationController::class, 'show'])->name('depreciations.show');
    Route::get('/depreciations/{id}/edit', [DepreciationController::class, 'edit'])->name('depreciations.edit');
    Route::put('/depreciations/{id}', [DepreciationController::class, 'update'])->name('depreciations.update');
    Route::delete('/depreciations/{id}', [DepreciationController::class, 'destroy'])->name('depreciations.destroy');

    // Rota para Relatórios
    Route::resource('reports', ReportController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');


    // Rota para Gerar PDF
    Route::get('/pdfs/pdf', [PdfController::class, 'geraPdf']);
});

// Rota padrão de home após login
Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
