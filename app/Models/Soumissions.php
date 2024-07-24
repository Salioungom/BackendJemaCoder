<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soumissions extends Model
{
    use HasFactory;
    protected $guarded=[];


    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->id_type == 'group' && !$model->equipe_id) {
                throw new \Exception('Une soumission de type équipe doit avoir un equipe_id.');
            }

            if ($model->id_type == 'indiv' && !$model->individuel_id) {
                throw new \Exception('Une soumission de type individuel doit avoir un individuel_id.');
            }
        });
    }

    public function equipe(){
        return $this->belongsTo(equipe::class,'equipe_id');
    }
    public function individuel(){
        return $this->belongsTo(individuel::class,'id');
    }
}
