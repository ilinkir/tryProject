<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//@todo: добавить модели для новостей, изображений, сидер, фабрику, подключить эластику для полнотекстового поиска, команду для индексации
class News extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'title',
        'code',
        'preview_text',
        'text',
        'category_id',
        'image_id',
        'is_active',
        'sort',
        'created_at',
        'updated_at',
    ];
}
