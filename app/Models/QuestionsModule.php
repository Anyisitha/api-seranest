<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsModule extends Model
{
    use HasFactory;

    public function answers()
    {
        return $this->hasMany(AnswersModule::class, "question_module_id");
    }
}
