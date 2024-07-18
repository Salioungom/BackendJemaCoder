<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUser;
use App\Models\individuel;
use App\Models\participant;
use Exception;
use Illuminate\Http\Request;

class IndividuelController extends Controller
{
   public function store(Request $request)
    {
        try {
            // Vérifiez si l'utilisateur est authentifié
            if (!auth()->check()) {
                return response()->json(['message' => 'Utilisateur non authentifié'], 401);
            }
            $indiv = new Individuel();
            // Récupérez l'ID de l'utilisateur connecté
            $indiv->user_simple_id = auth()->user()->id;

            // Vérifiez si le participant existe
            $participant = Participant::find($request->participant_id);
            if (!$participant) {
                return response()->json([
                    'message' => 'Participant non trouvé',
                ], 404);
            }
            $indiv->participant_id = $request->participant_id;
            $indiv->save();
            return response()->json([
                'success' => 'Individuel enregistré avec succès',
                'Individu' => $indiv
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
