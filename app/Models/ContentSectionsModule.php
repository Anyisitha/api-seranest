<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSectionsModule extends Model
{
    use HasFactory;

    public function questions()
    {
        return $this->hasMany(QuestionsModule::class, "content_section_module_id");
    }
}
