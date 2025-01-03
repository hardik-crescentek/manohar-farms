<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BillsController;
use App\Http\Controllers\Admin\CamerasController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DieselController;
use App\Http\Controllers\Admin\ExpensesController;
use App\Http\Controllers\Admin\ServiceContactController;
use App\Http\Controllers\Admin\FertilizerPesticidesController;
use App\Http\Controllers\Admin\FlushHistoryController;
use App\Http\Controllers\Admin\InfrastructureController;
use App\Http\Controllers\Admin\JivamrutFertilizerController;
use App\Http\Controllers\Admin\LandsController;
use App\Http\Controllers\Admin\ModulesController;
use App\Http\Controllers\Admin\PasswordResetController;
use App\Http\Controllers\Admin\PlantsController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\VehiclesController;
use App\Http\Controllers\Admin\WaterController;
use App\Http\Controllers\Admin\BoreWellsController;
use App\Http\Controllers\Admin\FilterHistoryController;
use App\Http\Controllers\Admin\MiscellaneousController;
use App\Http\Controllers\Admin\NotificationSettingsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PlotFertilizerController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\VermiCompostController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Cowshed\CowController;
use App\Http\Controllers\Cowshed\CustomerController;
use App\Http\Controllers\Cowshed\DashboardController as CowshedDashboardController;
use App\Http\Controllers\Cowshed\ExpensesController as CowshedExpensesController;
use App\Http\Controllers\Cowshed\GheeManagementController;
use App\Http\Controllers\Cowshed\GheeSellingController;
use App\Http\Controllers\Cowshed\GrassController;
use App\Http\Controllers\Cowshed\MilkController;
use App\Http\Controllers\Cowshed\ReportsController as CowshedReportsController;
use App\Http\Controllers\Cowshed\SettingsController;
use App\Http\Controllers\Cowshed\StaffController as CowshedStaffController;
use App\Models\CowshedSetting;
use Illuminate\Support\Facades\Route;
use App\Models\Customer;
use App\Models\MilkDelivery;
use App\Models\MilkPayment;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('post.login');

    Route::get('/forgot-password', [PasswordResetController::class, 'showResetForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});

Route::post('/save-token', [Controller::class, 'saveToken'])->name('save-token');
Route::get('/send-notification', [Controller::class, 'sendNotification'])->name('send.notification');

Route::get('/test', function () {

    echo "test";
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/sync-permissions', [DashboardController::class, 'syncPermissions']);

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Modules
    Route::resource('modules', ModulesController::class)->middleware('role_or_permission:super-admin|modules-view');

    // Admins
    Route::resource('admins', AdminController::class)->middleware('role_or_permission:super-admin|admins-view');

    // Plants
    Route::resource('plants', PlantsController::class)->middleware('role_or_permission:super-admin|plants-view');

    // Miscellaneous
    Route::resource('miscellaneous', MiscellaneousController::class)->middleware('role_or_permission:super-admin|miscellaneous-view');

    // Fertilizer Pesticides
    Route::resource('fertilizer-pesticides', FertilizerPesticidesController::class)->middleware('role_or_permission:super-admin|fertilizer-pesticides-view');
    Route::resource('jivamrut-fertilizer', JivamrutFertilizerController::class)->middleware('role_or_permission:super-admin|fertilizer-pesticides-view');
    Route::resource('vermi-compost', VermiCompostController::class)->middleware('role_or_permission:super-admin|fertilizer-pesticides-view');

    // status update of vermi-compost
    Route::patch('vermi-compost/{id}/status', [VermiCompostController::class, 'updateStatus'])->name('vermi-compost.updateStatus');

    Route::post('jivamrut-fertilizer/get-barrel-tables', [JivamrutFertilizerController::class, 'getBarrelsTables'])->name('jivamrut-fertilizer.get-barrel-tables');
    // get removed barrel tables
    Route::post('jivamrut-fertilizer/get-removed-barrel-tables', [JivamrutFertilizerController::class, 'getRemovedBarrelsTables'])->name('jivamrut-fertilizer.get-removed-barrel-tables');

    Route::post('jivamrut-fertilizer/save-barrel-entries', [JivamrutFertilizerController::class, 'saveBarrelEntries'])->name('jivamrut-fertilizer.save-barrel-entries');
    Route::put('jivamrut-fertilizer/update-barrel-entries/{id}', [JivamrutFertilizerController::class, 'updateBarrelEntries'])->name('jivamrut-fertilizer.update-barrel-entries');
    Route::post('jivamrut-fertilizer/update-barrel-status', [JivamrutFertilizerController::class, 'updateBarrelStatus'])->name('jivamrut-fertilizer.update-barrel-status');

    // remove barrel routes
    Route::put('jivamrut-fertilizer/remove-barrel/{id}', [JivamrutFertilizerController::class, 'removeBarrel'])->name('jivamrut-fertilizer.remove-barrel');



    // Staffs
    Route::resource('staffs', StaffController::class)->middleware('role_or_permission:super-admin|staffs-view');
    Route::post('staff/get-table', [StaffController::class, 'getTable'])->name('staff.get-table');

    Route::get('staff/teams/{id}', [StaffController::class, 'teams'])->name('staff.teams');
    Route::post('staff/get-attendance', [StaffController::class, 'getAttendance'])->name('staff.get-attendance');
    Route::get('staff/members-attendance', [StaffController::class, 'getDailyAttendence'])->name('staff.daily-attendance');
    Route::post('staff/members-attendance', [StaffController::class, 'addAttendence'])->name('staff.members-attendance');
    Route::get('staff/attendance-history', [StaffController::class, 'attendanceHistory'])->name('staff.attendance-history');
    Route::post('staff/get-attendance-history', [StaffController::class, 'getAttendanceHistory'])->name('staff.get-attendance-history');
    Route::post('staff/generate-attendance-pdf', [StaffController::class, 'generateAttendancePdf'])->name('attendance.generate-pdf');

    Route::post('staff-member/store', [StaffController::class, 'staffMemberCreate'])->name('staff-member.create');
    Route::put('staff-member/update/{id}', [StaffController::class, 'staffMemberUpdate'])->name('staff-member.update');
    Route::delete('staff-member/delete/{id}', [StaffController::class, 'staffMemberDelete'])->name('staff-member.delete');

    // Vehicles
    Route::resource('vehicles', VehiclesController::class)->middleware('role_or_permission:super-admin|vehicles-view');
    Route::post('vehicles/delete-document', [VehiclesController::class, 'deleteDocument'])->name('vehicle.delete-document')->middleware('role_or_permission:super-admin|vehicles-edit');
    Route::post('vehicles-service/save', [VehiclesController::class, 'vehicleServiceStore'])->name('vehicle.service-store')->middleware('role_or_permission:super-admin|vehicle-services-add');
    Route::put('vehicles-service/update/{service}', [VehiclesController::class, 'vehicleServiceUpdate'])->name('vehicle.service-update')->middleware('role_or_permission:super-admin|vehicle-services-add');
    Route::delete('vehicles-service/destroy/{id}', [VehiclesController::class, 'vehicleServiceDestroy'])->name('vehicle.service-destroy')->middleware('role_or_permission:super-admin|vehicle-services-add');

    // Diesel Managements
    Route::get('diesels', [DieselController::class, 'index'])->name('diesels.index')->middleware('role_or_permission:super-admin|diesels-view');
    Route::get('diesels/create', [DieselController::class, 'create'])->name('diesels.create')->middleware('role_or_permission:super-admin|diesels-add');
    Route::post('diesels', [DieselController::class, 'store'])->name('diesels.store')->middleware('role_or_permission:super-admin|diesels-add');
    Route::get('diesels/{diesel}/edit', [DieselController::class, 'edit'])->name('diesels.edit')->middleware('role_or_permission:super-admin|diesels-edit');
    Route::put('diesels/{diesel}', [DieselController::class, 'update'])->name('diesels.update')->middleware('role_or_permission:super-admin|diesels-edit');
    Route::delete('diesels/{diesel}', [DieselController::class, 'destroy'])->name('diesels.destroy')->middleware('role_or_permission:super-admin|diesels-delete');

    // Diesel Entries
    Route::get('diesel-entries', [DieselController::class, 'dieselEntriesIndex'])->name('diesel-entries.index')->middleware('role_or_permission:super-admin|diesel-entries-view');
    Route::get('diesel-entries/create', [DieselController::class, 'dieselEntriesCreate'])->name('diesel-entries.create')->middleware('role_or_permission:super-admin|diesel-entries-add');
    Route::post('diesel-entries', [DieselController::class, 'dieselEntriesStore'])->name('diesel-entries.store')->middleware('role_or_permission:super-admin|diesel-entries-add');
    Route::get('diesel-entries/{diesel_entry}/edit', [DieselController::class, 'dieselEntriesEdit'])->name('diesel-entries.edit')->middleware('role_or_permission:super-admin|diesel-entries-edit');
    Route::put('diesel-entries/{diesel_entry}', [DieselController::class, 'dieselEntriesUpdate'])->name('diesel-entries.update')->middleware('role_or_permission:super-admin|diesel-entries-edit');
    Route::delete('diesel-entries/{diesel_entry}', [DieselController::class, 'dieselEntriesDestroy'])->name('diesel-entries.destroy')->middleware('role_or_permission:super-admin|diesel-entries-delete');

    // Lands
    Route::resource('lands', LandsController::class)->middleware(['role_or_permission:super-admin|lands-view', 'checkPlotPermission']);
    Route::post('lands/save-documents', [LandsController::class, 'saveDocuments'])->name('lands.save-documents')->middleware('role_or_permission:super-admin|lands-add');

    // land parts
    Route::get('lands/{id}/maps', [LandsController::class, 'landMaps'])->name('lands.maps')->middleware(['role_or_permission:super-admin|lands-add', 'checkPlotPermission']);
    Route::post('land-parts/store', [LandsController::class, 'storeLandPart'])->name('land-parts.store')->middleware('role_or_permission:super-admin|lands-add');
    Route::delete('land-parts/{id}', [LandsController::class, 'destroyPart'])->name('land-parts.destroy')->middleware('role_or_permission:super-admin|lands-delete');
    Route::put('land-parts/update/{land}', [LandsController::class, 'updatePart'])->name('land-parts.update')->middleware('role_or_permission:super-admin|lands-edit');

    Route::get('land-parts/details/{id}', [LandsController::class, 'landPartDetails'])->name('land-parts.details');

    Route::post('land-parts/save-water-entries', [LandsController::class, 'saveWaterEntries'])->name('land-parts.save-water-entries');
    Route::post('water-entries/get-table', [LandsController::class, 'getWatersTable'])->name('water-entries.get-table');

    // Jivamrut Entires code

    Route::post('land-parts/save-jivamrut-entries', [LandsController::class, 'saveJivamrutEntries'])->name('land-parts.save-jivamrut-entries');
    Route::post('jivamrut-entries/get-table', [LandsController::class, 'getJivamrutTable'])->name('jivamrut-entries.get-table');

    Route::post('land-parts/save-fertilizer-entries', [LandsController::class, 'saveFertilizerEntries'])->name('land-parts.save-fertilizer-entries');
    Route::post('fertilizer-entries/get-table', [LandsController::class, 'getFertilizerTable'])->name('fertilizer-entries.get-table');

    Route::post('flush-history/store', [FlushHistoryController::class, 'store'])->name('flush-history.store');
    Route::put('flush-history/update/{flushHistory}', [FlushHistoryController::class, 'update'])->name('flush-history.update');
    Route::delete('flush-history/destroy/{flushHistory}', [FlushHistoryController::class, 'destroy'])->name('flush-history.destroy');

    // Plot Fertilizer Routes
    Route::post('plot-fertilizer/store', [PlotFertilizerController::class, 'store'])->name('plot-fertilizer.store');
    Route::put('plot-fertilizer/update/{plotFertilizer}', [PlotFertilizerController::class, 'update'])->name('plot-fertilizer.update');
    Route::delete('plot-fertilizer/destroy/{plotFertilizer}', [PlotFertilizerController::class, 'destroy'])->name('plot-fertilizer.destroy');

    // Water Managements
    Route::resource('water', WaterController::class)->middleware('role_or_permission:super-admin|water-view');

    // Bills
    Route::resource('bills', BillsController::class)->middleware('role_or_permission:super-admin|bills-view');
    Route::post('bills/get-table', [BillsController::class, 'getTable'])->middleware('role_or_permission:super-admin|bills-view')->name('bills.get-table');

    // Expenses
    Route::resource('expenses', ExpensesController::class)->middleware('role_or_permission:super-admin|expenses-view');

    // Cameras
    Route::resource('cameras', CamerasController::class)->middleware('role_or_permission:super-admin|cameras-view');

    // Cameras
    Route::resource('service-contacts', ServiceContactController::class)->middleware('role_or_permission:super-admin|service-contacts-view');

    // infrastructure
    Route::resource('infrastructure', InfrastructureController::class)->middleware('role_or_permission:super-admin|infrastructure-view');

    // bore-wells Managements
    Route::resource('bore-wells', BoreWellsController::class)->middleware('role_or_permission:super-admin|bore-wells-view');
    Route::get('bore-wells/{id}/filterHistory', [FilterHistoryController::class, 'index'])->name('filter-history.index');
    Route::get('bore-wells/{id}/filterHistory/create', [FilterHistoryController::class, 'create'])->name('filter-history.create');
    Route::post('filterHistory/store', [FilterHistoryController::class, 'store'])->name('filter-history.store');
    Route::get('bore-wells/{boreWellsId}/filterHistory/{id}/edit', [FilterHistoryController::class, 'edit'])->name('filter-history.edit');
    // Route::get('/filter-history/{id}/edit', 'Admin\FilterHistoryController@edit')->name('filter-history.edit');
    Route::put('filter/update/{filterHistory}', [FilterHistoryController::class, 'update'])->name('filter-history.update');
    Route::delete('filter/destroy/{filterHistory}', [FilterHistoryController::class, 'destroy'])->name('filter-history.destroy');

    // Manager tasks
    Route::resource('tasks', TaskController::class)->middleware('role_or_permission:super-admin|tasks-view');
    Route::post('tasks/status-update', [TaskController::class, 'statusUpdate'])->name('tasks.status-update')->middleware('role_or_permission:super-admin|tasks-view');

    Route::get('notification-settings', [NotificationSettingsController::class, 'index'])->name('notification-settings');
    Route::put('notification-settings/{notificationSetting}', [NotificationSettingsController::class, 'update'])->name('notification-settings.update');

    // all notifications
    Route::get('all-notifications', [NotificationController::class, 'index'])->name('all-notifications');
    Route::put('update-notifications/{notification}', [NotificationController::class, 'update'])->name('all-notifications.update');


    // reports
    Route::get('reports/index', [ReportsController::class, 'reportsIndex'])->name('reports.index');

    Route::get('reports/expenses', [ReportsController::class, 'expensesIndex'])->name('expenses-reports.index');
    Route::post('reports/get-table', [ReportsController::class, 'getExpenseTable'])->name('expenses-reports.get-table');
    Route::post('reports/generate-expenses-pdf', [ReportsController::class, 'generateExpensesPdf'])->name('expenses-reports.generate-pdf');

    Route::get('reports/water', [ReportsController::class, 'waterIndex'])->name('water-reports.index');
    Route::post('water/get-table', [ReportsController::class, 'getWaterTable'])->name('water-reports.get-table');
    Route::post('water/generate-water-pdf', [ReportsController::class, 'generateWaterPdf'])->name('water-reports.generate-pdf');

    Route::get('reports/diesel', [ReportsController::class, 'dieselIndex'])->name('diesel-reports.index');
    Route::post('diesel/get-table', [ReportsController::class, 'getDieselTable'])->name('diesel-reports.get-table');
    Route::post('diesel/generate-diesel-pdf', [ReportsController::class, 'generateDieselPdf'])->name('diesel-reports.generate-pdf');

    Route::get('reports/diesel-management', [ReportsController::class, 'dieselManagementIndex'])->name('diesel-management-reports.index');
    Route::post('diesel-management/get-table', [ReportsController::class, 'getDieselManagementTable'])->name('diesel-management-reports.get-table');
    Route::post('diesel-management/generate-diesel-pdf', [ReportsController::class, 'generateDieselManagementPdf'])->name('diesel-management-reports.generate-pdf');

    Route::get('reports/bill', [ReportsController::class, 'billIndex'])->name('bill-reports.index');
    Route::post('bill/get-table', [ReportsController::class, 'getBillTable'])->name('bill-reports.get-table');
    Route::post('bill/generate-bill-pdf', [ReportsController::class, 'generateBillPdf'])->name('bill-reports.generate-pdf');

    Route::get('reports/plant', [ReportsController::class, 'plantIndex'])->name('plant-reports.index');
    Route::post('plants/get-table', [ReportsController::class, 'getPlantTable'])->name('plants-reports.get-table');
    Route::post('plants/generate-plants-pdf', [ReportsController::class, 'generatePlantPdf'])->name('plants-reports.generate-pdf');

    Route::get('reports/fertilizer-pesticides', [ReportsController::class, 'fertilizerPesticidesIndex'])->name('fertilizer-pesticides-reports.index');
    Route::post('fertilizer-pesticides/get-table', [ReportsController::class, 'getFertilizerPesticidesTable'])->name('fertilizer-pesticides-reports.get-table');
    Route::post('fertilizer-pesticides/generate-fertilizer-pesticides-pdf', [ReportsController::class, 'generateFertilizerPesticidesPdf'])->name('fertilizer-pesticides-reports.generate-pdf');

    Route::get('reports/staffs', [ReportsController::class, 'staffsIndex'])->name('staffs-reports.index');
    Route::post('staffs/get-table', [ReportsController::class, 'getStaffsTable'])->name('staffs-reports.get-table');
    Route::post('staffs/generate-staffs-pdf', [ReportsController::class, 'generateStaffsPdf'])->name('staffs-reports.generate-pdf');

    Route::get('reports/vehicles-services', [ReportsController::class, 'vehicleServiceIndex'])->name('vehicles-services-reports.index');
    Route::post('vehicles-services/get-table', [ReportsController::class, 'getVehicleServiceTable'])->name('vehicles-services-reports.get-table');
    Route::post('vehicles-services/generate-vehicles-services-pdf', [ReportsController::class, 'generateVehicleServicePdf'])->name('vehicles-services-reports.generate-pdf');

    Route::get('reports/infrastructure', [ReportsController::class, 'infrastructureIndex'])->name('infrastructure-reports.index');
    Route::post('infrastructure/get-table', [ReportsController::class, 'getInfrastructureTable'])->name('infrastructure-reports.get-table');
    Route::post('infrastructure/generate-infrastructure-pdf', [ReportsController::class, 'generateInfrastructurePdf'])->name('infrastructure-reports.generate-pdf');

    // Plot report routes

    Route::get('reports/plot', [ReportsController::class, 'plotIndex'])->name('plot-reports.index');
    Route::post('plot/get-table', [ReportsController::class, 'getPlotTable'])->name('plot-reports.get-table');
    Route::post('plot/generate-plot-pdf', [ReportsController::class, 'generatePlotPdf'])->name('plot-reports.generate-pdf');

});


Route::get('plants/reports', [ReportsController::class, 'plantIndex'])->name('plants-reports.index');

// manage Cowshed
Route::group(['middleware' => ['auth'], 'prefix' => 'cowshed', 'as' => 'cowshed.'], function () {

    Route::get('/dashboard', [CowshedDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('settings', [SettingsController::class, 'settings'])->name('settings');
    Route::post('settings/update/{setting}', [SettingsController::class, 'update'])->name('settings.update');

    // cows
    Route::resource('cows', CowController::class);
    Route::post('cows/get-table', [CowController::class, 'getCowTable'])->name('cows.get-table');
    Route::post('vaccinations/store', [CowController::class, 'storeVaccination'])->name('vaccinations.store');

    // Staffs
    Route::resource('staffs', CowshedStaffController::class);
    Route::post('staff/get-table', [CowshedStaffController::class, 'getTable'])->name('staff.get-table');

    // expenses
    Route::resource('expenses', CowshedExpensesController::class);

    // grass
    Route::resource('grass', GrassController::class);

    // customers
    Route::resource('customers', CustomerController::class);

    // ghee management
    Route::resource('ghee-management', GheeManagementController::class);

    // ghee sellings
    Route::resource('ghee-sellings', GheeSellingController::class);

    // daily-milk
    Route::get('daily-milk', [MilkController::class, 'dailyMilkIndex'])->name('daily-milk.index');
    Route::post('daily-milk/get-table', [MilkController::class, 'getDailyMilkTable'])->name('daily-milk.get-table');
    Route::post('daily-milk/get-delivery-pdf', [MilkController::class, 'getDeliveryPdf'])->name('daily-milk.get-delivery-pdf');
    Route::post('daily-milk/update', [MilkController::class, 'updateDailyDelivery'])->name('daily-milk.update');

    Route::post('daily-milk/save-entry', [MilkController::class, 'saveInHouseDelivery'])->name('daily-milk.save-inhouse-delivery');

    // milk-payments
    Route::get('milk-payments', [MilkController::class, 'milkPaymentsIndex'])->name('milk-payments.index');
    Route::post('milk-payments/history', [MilkController::class, 'getMilkPaymentHistory'])->name('milk-payments.history');
    Route::post('milk-payments/get-report', [MilkController::class, 'getPaymentReport'])->name('milk-payments.get-report');
    Route::post('milk-payments/save-image', [MilkController::class, 'savePaymentImage'])->name('milk-payments.save-image');
    Route::post('milk-payments/status-update', [MilkController::class, 'updatePaymentStatus'])->name('milk-payments.status-update');

    // Report
    Route::get('reports/milk-report', [CowshedReportsController::class, 'milkReport'])->name('reports.milk-report');
    Route::post('milk-deliveries/milk-history-table', [CowshedReportsController::class, 'milkHistoryTable'])->name('milk-deliveries.milk-history-table');
    Route::post('milk-deliveries/get-delivery-report', [CowshedReportsController::class, 'getDeliveryReport'])->name('milk-deliveries.get-delivery-report');

    Route::get('reports/staff-report', [CowshedReportsController::class, 'staffReport'])->name('reports.staff-report');
    Route::post('staffs/get-table', [CowshedReportsController::class, 'getStaffsTable'])->name('staffs-reports.get-table');
    Route::post('staffs/generate-staffs-pdf', [CowshedReportsController::class, 'generateStaffsPdf'])->name('staffs-reports.generate-pdf');

    Route::get('reports/expenses-report', [CowshedReportsController::class, 'expensesIndex'])->name('expenses-reports.index');
    Route::post('expenses/get-table', [CowshedReportsController::class, 'getExpenseTable'])->name('expenses-reports.get-table');
    Route::post('expenses/generate-expenses-pdf', [CowshedReportsController::class, 'generateExpensesPdf'])->name('expenses-reports.generate-pdf');

    Route::get('reports/grass-report', [CowshedReportsController::class, 'grassReport'])->name('reports.grass-report');
    Route::post('grass/get-table', [CowshedReportsController::class, 'getGrassTable'])->name('grass-reports.get-table');
    Route::post('grass/generate-grass-pdf', [CowshedReportsController::class, 'generateGrassPdf'])->name('grass-reports.generate-pdf');

    Route::get('reports/ghee-report', [CowshedReportsController::class, 'gheeReport'])->name('reports.ghee-report');
    Route::post('ghee/get-table', [CowshedReportsController::class, 'getGheeTable'])->name('ghee-reports.get-table');
    Route::post('ghee/generate-ghee-pdf', [CowshedReportsController::class, 'generateGheePdf'])->name('ghee-reports.generate-pdf');

    Route::get('reports/ghee-selling-report', [CowshedReportsController::class, 'gheeSellingReport'])->name('reports.ghee-selling-report');
    Route::post('ghee-selling/get-table', [CowshedReportsController::class, 'getGheeSellingTable'])->name('ghee-selling-reports.get-table');
    Route::post('ghee-selling/generate-ghee-selling-pdf', [CowshedReportsController::class, 'generateGheeSellingPdf'])->name('ghee-selling-reports.generate-pdf');
});
