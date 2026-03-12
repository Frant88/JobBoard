<?php

use App\Http\Controllers\Application\ApplicationCandidateController;
use App\Http\Controllers\Application\ApplicationsStatusController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\CandidateDashboardController;
use App\Http\Controllers\Dashboard\EmployerDashboardController;
use App\Http\Controllers\Dashboard\RedirectDashboardController;
use App\Http\Controllers\Listings\ListingsController;
use App\Http\Controllers\Listings\ListingsEmployerController;
use App\Http\Controllers\Profilo\ProfileController;
use App\Http\Controllers\Profilo\ProfiloRedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');



Route::middleware('guest')->group(function(){
    // registrazione

        Route::get('/register/candidate',[RegisterController::class, 'showRegisterCandidate'])->name('register.candidate');
        Route::get('/register/employer',[RegisterController::class, 'showRegisterEmployer'])->name('register.employer');


        Route::post('/register/candidate',[RegisterController::class,'RegisterCandidate'])->name('register.candidate.store');
        Route::post('/register/employer',[RegisterController::class, 'RegisterEmployer'])->name('register.employer.store');

    //login

        Route::get('/login',[LoginController::class, 'showLogin'])->name('login');
        Route::post('/login',[LoginController::class,'login'])->name('login.store');

});

Route::middleware('auth')->group(function(){
    //logout
        Route::post('/logout',LogoutController::class)->name('logout');

    //profile
        Route::get('profile',ProfiloRedirectController::class)->name('profile');

    //verifica Email
        Route::get('/email/verify',[EmailVerificationController::class,'show'])->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class,'verify'])->middleware('signed')->name('verification.verify');
        Route::post('/email/verification-notification',[EmailVerificationController::class,'resend'])->middleware('throttle:6,1')->name('verification.send');

    //dashboard
        Route::get('/dashboard',RedirectDashboardController::class)->name('dashboard');

    //listings
        Route::get('/listings/{listing:slug}',[ListingsController::class,'show'])->name('listing.show');

    
    Route::middleware('employer')->group(function(){

        //dashboard-employer
        Route::get('/dashboard/employer',[EmployerDashboardController::class,'index'])->name('dashboard.employer');

        //profile-employer
        Route::put('/profile/employer',[ProfileController::class,'updateEmployer'])->name('profile.employer.update');

        Route::middleware('verified')->group(function (){

            //listings-employer
            Route::get('/create/listings',[ListingsEmployerController::class,'index'])->name('listings.show');
            Route::post('/create/listings',[ListingsEmployerController::class,'store'])->name('listings.store');
            Route::get('/listings/{listing:slug}/edit',[ListingsEmployerController::class,'edit'])->name('listings.edit');
            Route::put('/listing/{listing:slug}/update',[ListingsEmployerController::class,'update'])->name('listing.update');

            //applications-employer
            Route::put('/application/{application:id}/accepted',[ApplicationsStatusController::class,'accepted'])->name('application.accepted');
            Route::put('/application/{application:id}/rejected',[ApplicationsStatusController::class,'rejected'])->name('application.rejected');
        });
    });

    Route::middleware('candidate')->group(function(){
        //dashboard-candidate
         Route::get('/dashboard/candidate',[CandidateDashboardController::class,'index'])->name('dashboard.candidate');
         //profile-candidate
         Route::put('/profile/candidate',[ProfileController::class,'updateCandidate'])->name('profile.candidate.update');

          Route::middleware('verified')->group(function (){
            //listings-candidate
            Route::get('/listings',[ListingsController::class,'index'])->name('listings.candidate.show');
            //applications-candidate
            Route::post('/application/create/{listing:slug}',[ApplicationCandidateController::class,'store'])->name('application.store');
          });  
    });

            
           
});

