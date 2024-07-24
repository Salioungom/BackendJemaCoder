<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Defis;
use App\Models\Hackathon;

class DefisController extends Controller
{
    public function store(Request $request)
    {
        // Validation des données de la requête
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'ressource' => 'required|string',
            'critere' => 'required|string',
            'hackathon_id' => 'required|exists:hackathons,id'
        ]);

        try {
            // Vérification de l'existence du hackathon
            $hackathon = Hackathon::find($validatedData['hackathon_id']);
            if (!$hackathon) {
                return response()->json([
                    'message' => 'Hackathon non trouvé',
                ], 404);
            }

            // Vérification que l'utilisateur authentifié est l'organisateur du hackathon
            $user = auth()->user();
            if ($user->role !== 'organisateur' || $user->id !== $hackathon->user_id) {
                return response()->json([
                    'message' => 'Vous n\'êtes pas autorisé à créer des défis pour ce hackathon',
                ], 403);
            }

            // Création du défi
            $defi = new Defis();
            $defi->titre = $validatedData['titre'];
            $defi->description = $validatedData['description'];
            $defi->ressource = $validatedData['ressource'];
            $defi->critere = $validatedData['critere'];
            $defi->hackathon_id = $validatedData['hackathon_id'];
            $defi->save();

            return response()->json([
                'message' => 'Défi créé avec succès',
                'defi' => $defi,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création du défi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
