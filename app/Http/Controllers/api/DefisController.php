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
        // $request->validate([
        //     'titre' => 'required|string',
        //     'description' => 'required|string',
        //     'ressouce' => 'required|string',
        //     'critere' => 'required|string',
        //     'hackathon_id' => 'required|exists:hackathons,id'
        // ]);
        try {
            $hackathon = Hackathon::find($request->hackathon_id);
            if (!$hackathon) {
                return response()->json([
                    'message' => 'Hackathon non trouvé',
                ], 404);
            }
            $defi = new Defis();
            $defi->titre = $request->titre;
            $defi->description = $request->description;
            $defi->ressource = $request->ressource;
            $defi->critere = $request->critere;
            $defi->hackathon_id = $request->hackathon_id;
            // dd($defi);
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
