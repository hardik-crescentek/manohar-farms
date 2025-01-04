<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\WaterController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BillsController;
use App\Http\Controllers\Api\DieselEntriesController;
use App\Http\Controllers\Api\DieselManagementController;
use App\Http\Controllers\Api\ExpensesController;
use App\Http\Controllers\Api\FertilizerEntryController;
use App\Http\Controllers\Api\FertilizerPesticidesController;
use App\Http\Controllers\Api\JivamrutEntryController;
use App\Http\Controllers\Api\LandsController;
use App\Http\Controllers\Api\MapsController;
use App\Http\Controllers\Api\MiscellaneousController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PlantsController;
use App\Http\Controllers\Api\ReportsController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\VehiclesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/maps/{id}/get-valves', [MapsController::class, 'getValves']);
    Route::get('/get-maps', [MapsController::class, 'getMaps']);
    Route::get('/maps/{id}/latest-valve', [MapsController::class, 'getLatestOpenValve']);

    Route::resource('admins', AdminController::class);
    Route::resource('plants', PlantsController::class);
    Route::resource('fertilizer-pesticides', FertilizerPesticidesController::class);
    Route::resource('staffs', StaffController::class);
    Route::resource('vehicles', VehiclesController::class);
    Route::resource('diesel-management', DieselManagementController::class);
    Route::resource('diesel-entries', DieselEntriesController::class);
    Route::resource('water-management', WaterController::class);
    Route::resource('lands', LandsController::class);
    Route::resource('bills', BillsController::class);
    Route::resource('expenses', ExpensesController::class);
    // Miscellaneous
    Route::resource('miscellaneous', MiscellaneousController::class);

    Route::post('vehicles/delete-document', [VehiclesController::class, 'deleteDocument']);

    Route::post('land-parts/save-water', [LandsController::class, 'saveWater']);
    Route::get('land-parts/get-water/{id}', [LandsController::class, 'getWaterLandPartWise']);
    Route::delete('land-parts/delete-water/{id}', [LandsController::class, 'destroyWaterLandPartWise']);


    Route::post('fertilizer-entries/save', [FertilizerEntryController::class, 'saveFertilizerEntry']);
    Route::get('fertilizer-entries/plot-wise/{id}', [FertilizerEntryController::class, 'getFertilizerPlotWise']);

    Route::post('jivamrut-entries/save', [JivamrutEntryController::class, 'saveJivamrutEntry']);
    Route::get('jivamrut-entries/plot-wise/{id}', [JivamrutEntryController::class, 'getJivamrutPlotWise']);
    Route::put('jivamrut-entries/update/{id}', [JivamrutEntryController::class, 'updateJivamrutEntry']);
    Route::delete('jivamrut-entries/delete/{id}', [JivamrutEntryController::class, 'destroyJivamrutEntry']);

    Route::get('reports/get-report', [ReportsController::class, 'getReport']);
    Route::get('reports/get-home-report', [ReportsController::class, 'getHomeReport']);
    Route::post('reports/get-expenses-report', [ReportsController::class, 'getExpensesReport']);
    Route::post('reports/get-expenses-pdf', [ReportsController::class, 'getExpensesPdf']);

    Route::post('reports/get-water-report', [ReportsController::class, 'getWaterReport']);
    Route::post('reports/get-water-pdf', [ReportsController::class, 'getWaterPdf']);

    Route::post('reports/get-diesel-report', [ReportsController::class, 'getDieselReport']);
    Route::post('reports/get-diesel-pdf', [ReportsController::class, 'getDieselPdf']);

    Route::post('reports/get-diesel-management-report', [ReportsController::class, 'getDieselManagementReport']);
    Route::post('reports/get-diesel-management-pdf', [ReportsController::class, 'getDieselManagementPdf']);

    Route::post('reports/get-bill-report', [ReportsController::class, 'getBillReport']);
    Route::post('reports/get-bill-pdf', [ReportsController::class, 'getBillPdf']);

    Route::post('reports/get-plants-report', [ReportsController::class, 'getPlantsReport']);
    Route::post('reports/get-plants-pdf', [ReportsController::class, 'getPlantsPdf']);

    Route::post('reports/get-staffs-report', [ReportsController::class, 'getStaffsReport']);
    Route::post('reports/get-staffs-pdf', [ReportsController::class, 'getStaffsPdf']);

    Route::post('reports/get-fertilizer-report', [ReportsController::class, 'getFertilizerReport']);
    Route::post('reports/get-fertilizer-pdf', [ReportsController::class, 'getFertilizerPdf']);

    Route::get('notifications', [NotificationController::class, 'notifications']);
});
