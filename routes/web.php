<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DentistController;
use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
return view('welcome');
});


Route::middleware(['auth', 'verified'])->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// 1. Patient Medical Records (View Only)
// Strawberry can access this to see her "Full Records"
Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');


// Appointments
Route::resource('appointments', AppointmentController::class);
Route::post('appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])
->name('appointments.updateStatus');
Route::get('api/available-slots', [AppointmentController::class, 'getAvailableSlots'])
->name('api.available-slots');


// 2. Admin Routes (Protected by 'admin' middleware)
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
Route::resource('patients', PatientController::class);
Route::resource('dentists', DentistController::class);
Route::resource('services', ServiceController::class);

// Admin Medical Records: Store, Update, and Destroy
// We exclude 'index' here because the patient route above handles viewing.
Route::resource('medical-records', MedicalRecordController::class)->except(['index']);
});
});


Route::middleware('auth')->group(function () {
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';