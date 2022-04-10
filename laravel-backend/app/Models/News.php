<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//@todo: добавить модели для новостей, изображений, сидер, фабрику, подключить эластику для полнотекстового поиска, команду для индексации
class News extends Model
{
    use HasFactory, HasUuid, Searchable;

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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'updated_at' => 'date:M j, Y, g:i a',
        'created_at' => 'date:M j, Y, g:i a',
    ]; //Конвертация значений, особенно удобно если нужно хранить данные в json формате, то в sql нужно создать поле text и класть туда просто массив невозможно и будет ошибка, для этого просто добавить поле и array, напр - 'options' => 'array'

    /**
     * The event map for the model.
     *
     * @var array
     */
//    protected $dispatchesEvents = [
//        'updated' => News\NewsUpdated::class,
//    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function toSearchArray() : array
    {
        // Наличие пользовательского метода
        // преобразования модели в поисковый массив
        // позволит нам настраивать данные
        // которые будут доступны для поиска
        // по каждой модели.
        return [
            'title' => $this->title,
            'code' => $this->code,
            'preview_text' => $this->preview_text,
            'text' => $this->text,
            'is_active' => $this->is_active,
            'category_id' => $this->category->id,
            'sort' => $this->sort,
            'year' => $this->created_at->year,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
