<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;
use Illuminate\Database\Eloquent\Model;
use App\Models\News;
use MoonShine\Fields\Date;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;


class NewsResource extends ModelResource
{
    protected string $model = News::class;

    protected string $title = 'Новости';
    protected string $column = 'title';
    protected string $sortDirection = 'ASC';


    public function search(): array
    {
        return ['id', 'title', 'description', 'date'];
    }

    public function fields(): array
    {
        return [
                HasMany::make('Comments', 'comments', CommentResource::class)->onlyLink(),
                Block::make([

                Text::make('Заголовок', 'title')->showOnExport(),
                Text::make('Описание','description')->showOnExport(),
                Text::make("Текст",'text')->showOnExport(),
                Date::make("Дата публикации",'date')->showOnExport(),
                Image::make("Картинка",'image')->showOnExport(),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
