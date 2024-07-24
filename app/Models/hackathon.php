<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hackathon extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function users(){
        return $this->belongsTo(User::class);
    }
    public function equipe(){
        return $this->hasMany(equipe::class, 'equipe_id');
    }
    
    public function individuel(){
        return $this->hasMany(individuel::class, 'id');
    }
    public function tag(){
        return $this->hasMany(tag::class);
    }
    public function defis(){
        return $this->hasMany(defis::class, 'id');
    }
    public function feedback(){
        return $this->hasMany(feedback::class,'id');
    }

    // public function Analyse(){
    //     return $this->hasMany(Analyse::class);
    // }
}

