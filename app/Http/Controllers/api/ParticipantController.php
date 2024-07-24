<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\hackathon;
use App\Models\participant;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
  public function index(){
    $participants = participant::all();
    return response()->json(['participants' => $participants]);
  }
public function store(Request $request)
{
    try {
        $hackathon = hackathon::find($request->hackathon_id);
        if (!$hackathon) {
            return response()->json([
                'message' => 'Hackathon non trouvé',
            ], 404);
        }
        if ($hackathon->status != 'inscriptions ouvert') {
            return response()->json([
                'message' => 'Hackathon non disponible',
            ], 404);
        }
        if (Carbon::parse($hackathon->date_fin)->eq(Carbon::now())) {
            $hackathon->status = 'inscriptions férmées';
            return response()->json([
                'status' => $hackathon->status,
            ], 400);
        }
        

        if($hackathon->organisateur_id = auth()->user()->id){
            return response()->json([
                'message' => 'en tant que l\'organisateur, vous ne pouvez pas vous inscrire à votre propre hackathon',
            ], 403);
        }
        // dd($hackathon);
        $participant = new Participant();
        $participant->hackaton_id = $request->hackathon_id;
        $participant->status = $request->status;
        $participant->date_inscription = $request->date_inscription;
        $participant->type = $request->type;
        $participant->motivation = $request->motivation;
        // dd($participant);
        $participant->save();

        return response()->json([
            'message' => 'Participant créé avec succès',
            'participant' => $participant,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Erreur lors de la création du participant',
            'error' => $e->getMessage(),
        ]);
    }
}

public function update(Request $request, $id)
{
    $participant = Participant::find($id);
    $participant->update($request->all());
    $participant->save();

    return response()->json(['message' => 'Participant mis à jour avec succès']);
}

public function destroy($id)
{
    $participant = Participant::find($id);
    $participant->delete();

    return response()->json(['message' => 'Participant supprimé avec succès']);
}
}
