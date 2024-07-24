<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\equipe;
use App\Models\hackathon;
use App\Models\User;
use App\Models\MembreEquipe;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\HackathonController;

class MembreEquipeController extends Controller
{
    public function store(Request $request)
    {
        try {
            if (!auth()->check()) {
                return response()->json(['message' => 'Utilisateur non authentifié'], 401);
            }

            $user = auth()->user();

            // Vérifier le rôle de l'utilisateur
            if ($user->role !== 'participant') {
                return response()->json([
                    'message' => 'Vous n\'êtes pas autorisé à rejoindre une équipe',
                ], 403);
            }

            $membre = new MembreEquipe();
            $membre->user_simple_id = $user->id;

            $equipe = equipe::find($request->equipe_id);
            if (!$equipe) {
                return response()->json([
                    'message' => 'Équipe non trouvée',
                ], 404);
            }

            if ($equipe->membres()->where('user_simple_id', $user->id)->exists()) {
                return response()->json([
                    'message' => 'Vous êtes déjà membre de cette équipe',
                ], 404);
            }

            $equipe->nbre_membre = 2;
            if ($equipe->membres()->count() >= $equipe->nbre_membre) {
                return response()->json([
                    'message' => 'L\'équipe est déjà complète',
                ], 404);
            }

            $membre->equipe_id = $request->equipe_id;
            $membre->save();

            return response()->json([
                'success' => 'Membre enregistré avec succès dans l\'équipe',
                'Membre_Equipe' => $membre
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
