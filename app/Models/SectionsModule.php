<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionsModule extends Model
{
    use HasFactory;

    public function content()
    {
        return $this->hasMany(ContentSectionsModule::class, "section_module_id");
    }
}
