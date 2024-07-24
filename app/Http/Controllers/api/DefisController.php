<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\defis;
use App\Models\hackathon;


class DefisController extends Controller
{
    public function store(Request $request){
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
            if($hackathon->organisateur_id != auth()->user()->id){
                return response()->json([
                    'message' => 'Vous n\'avez pas le droit de créer un défi pour ce hackathon parceque vous n\'êtes pas l\'organisateur',
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
