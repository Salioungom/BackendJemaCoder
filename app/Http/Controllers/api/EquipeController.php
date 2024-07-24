<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\equipe;
use App\Models\participant;
use Exception;
use Illuminate\Http\Request;

class EquipeController extends Controller
{
  
  public function index(){
    try{
           
         $equipe = equipe::all();
         return response()->json([
             'success' => true,
             'equipe' => $equipe
         ], 200);
    }catch(Exception $e){
        return response()->json([
            'error' => $e->getMessage()], 
            500);
        
        }
  }
    public function store(Request $request)
    {        

        try {
            
            $equipe = new equipe();
            $participant = participant::find($request->participant_id);
            if (!$participant) {
                return response()->json([
                    'message' => 'Participant non trouvé',
                ], 404);
            }
            $equipe->name = $request->name;
            $equipe->participant_id = $request->participant_id;
            $equipe->save();
            return response()->json([
                'success' => 'Equipe créer avec succès',
                'Equipe' => $equipe
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
