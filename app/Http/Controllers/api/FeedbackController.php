<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback; // Ajoutez cette ligne
use App\Models\hackathon;
use Exception;
use Illuminate\Support\Facades\Auth; // Ajoutez cette ligne pour utiliser auth()


class FeedbackController extends Controller
{
    public function index()
    {
       try{
          $feedbacks = Feedback::all();
        //   dd($feedbacks);
        return response()->json([
            'message' => 'Feedbacks récupérés avec succès',
            'feedbacks' => $feedbacks,
        ], 200);

       }catch(Exception $e){
        return response()->json([
            'message' => 'Erreur lors de la récupération des feedbacks',
        ], 500);
       }
    }

    public function show($id)
    {

    }
     public function store(Request $request)

    {
    $request->validate([
        'hackathon_id' => 'required|exists:hackathons,id',  // Ajoutez une vérification pour l'existence du hackathon
        'messagefeedback' => 'required',
        'user_id'=>'required|exists:users,id',
    ]);
   try{
    $hackathon = hackathon::find($request->hackathon_id);
    if (!$hackathon) {
        return response()->json([
            'message' => 'Hackathon non trouvé',
        ], 404);
    }
    $feedback=new Feedback();
    $feedback->hackathon_id=$request->hackathon_id;
    $feedback->messagefeedback=$request->messagefeedback;
    $feedback->user_id=$request->user_id;
    $feedback->user_id = auth()->check() ? auth()->user()->id : null;
    if ($feedback->user_id === null) {
        return response()->json([
            'message' => 'Utilisateur non authentifié',
        ], 401);
    }
    $feedback->save();
    return response()->json([
            'message' => 'Feedback créé avec succès',
            'feedback' => $feedback,
        ], 201);
   }catch(Exception $e){
        return response()->json([
            'message' => 'Erreur lors de la création du feedback',
        ], 500);
   }
}

    public function update(Request $request, $id)
    {
        // Code pour mettre à jour une ressource existante
    }

    public function destroy($id)
    {
        // Code pour supprimer une ressource
    }
}
