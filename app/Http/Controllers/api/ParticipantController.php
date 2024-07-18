<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\hackathon;
use App\Models\participant;
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
