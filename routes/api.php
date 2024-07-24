<?php

use App\Http\Controllers\Api\DefisController;
use App\Http\Controllers\Api\EquipeController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\hackathonController;
use App\Http\Controllers\Api\IndividuelController;
use App\Http\Controllers\Api\MembreController;
use App\Http\Controllers\Api\MembreEquipeController;
use App\Http\Controllers\Api\ParticipantController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;



Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user(); });
    //les feedbacks    
    Route::post('/feedback',[FeedbackController::class, 'store']);
    Route::get('/feedback/index', [FeedbackController::class, 'index']);
    Route::get('/feedback/{feedback}',[FeedbackController::class,'show']);
    Route::put('/feedback/{feedback}',[FeedbackController::class,'update']);
    Route::delete('/feedback/{feedback}',[FeedbackController::class,'destroy']);


    //defis
    Route::post('/defi/add',[DefisController::class, 'store']);
    Route::get('/defi/index',[DefisController::class, 'index']);
    Route::get('/defi/{defi}',[DefisController::class, 'show']);
    Route::put('/defi/{defi}',[DefisController::class, 'update']);
    Route::delete('/defi/{defi}',[DefisController::class, 'destroy']);

    

    //indiv
    Route::post('/indiv/create',[IndividuelController::class, 'store']);

    //création des equipe
    Route::post('/equipe/create', [EquipeController::class, 'store']);
    Route::get('/equipe/index', [EquipeController::class, 'index']);
    Route::get('/equipe/{equipe}', [EquipeController::class, 'show']);
    Route::put('/equipe/{equipe}', [EquipeController::class, 'update']);
    Route::delete('/equipe/{equipe}', [EquipeController::class, 'destroy']);
    Route::get('/equipe/{equipe}/participants', [EquipeController::class, 'participants']);

    //ajout des membres dans l'equipe
    Route::post('/membre/add', [MembreEquipeController::class, 'store']);
    Route::get('/membre/index', [MembreEquipeController::class, 'index']);
    Route::get('/membre/{membre}', [MembreEquipeController::class, 'show']);
    Route::put('/membre/{membre}', [MembreEquipeController::class, 'update']);
    Route::delete('/membre/{membre}', [MembreEquipeController::class, 'destroy']);


//profil
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::post('/logout', [UserController::class, 'logout']);

    //pour les participants
    Route::post('participants/create', [ParticipantController::class, 'store']);
    Route::get('participants/index', [ParticipantController::class, 'index']);
    Route::get('participants/{participant}', [ParticipantController::class, 'show']);
    Route::put('participants/{participant}', [ParticipantController::class, 'update']);
    Route::delete('participants/{participant}', [ParticipantController::class, 'destroy']);


    Route::middleware('check.role:1')->group(function () {
        Route::put('/hackathons/update/{hackathon}', [HackathonController::class, 'update']);
        Route::delete('/hackathons/delete/{hackathon}', [HackathonController::class, 'destroy']);
        Route::post('/hackathons/create', [HackathonController::class, 'store']);
    });;
    Route::get('/hackathons', [HackathonController::class, 'index']);
   });
