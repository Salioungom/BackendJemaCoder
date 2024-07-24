<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class equipe extends Model
{
    use HasFactory;
    protected $guarded=[];

   public function hackathon(){
    return $this->belongsTo(hackathon::class,'equipe_id');
   }
   public function soumission(){
    return $this->hasMany(Soumissions::class, 'equipe_id');
   }
   public function membres()
   {
       return $this->hasMany(MembreEquipe::class, 'equipe_id');
   }
}
