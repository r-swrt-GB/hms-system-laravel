<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionsController;
use Illuminate\Support\Facades\Route;

// Authenticated requests
Route::middleware('auth')->group(function () {

    Route::prefix('/modules/{module}')->group(function () {

        //Submissions
        //Create
        Route::post('/assignments/{assignment}/submissions/create', [SubmissionsController::class, 'create'])->name('api.submissions.create');
        //Update
        Route::patch('/assignments/{assignment}/submissions/{submission}', [SubmissionsController::class, 'update'])->name('api.submissions.update');
        //Delete
        Route::delete('/assignments/{assignment}/submissions/{submission}', [SubmissionsController::class, 'delete'])->name('api.submissions.delete');
        //Read
        Route::get('/assignments/{assignment}/submissions/{submission}', [SubmissionsController::class, 'read'])->name('api.submissions.read');

    });


    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
