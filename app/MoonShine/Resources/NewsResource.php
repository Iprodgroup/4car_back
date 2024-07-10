<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;
use Illuminate\Database\Eloquent\Model;
use App\Models\News;
use MoonShine\Components\Modal;
use MoonShine\Fields\Date;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;


class NewsResource extends ModelResource
{
    protected string $model = News::class;

    protected string $title = 'Новости';
    protected string $column = 'id';
    protected string $sortDirection = 'ASC';


    public function search(): array
    {
        return ['id', 'title', 'description', 'date'];
    }
    /**
     * @return list<MoonShineComponent|Field>
     */

//    public function components(): array
//    {
//        Modal::make(
//            title: "Комментарии",
//            components: HasMany::make('Комментарии', 'comments', resource: new CommentResource())
//                ->creatable(),
////                          ->fields([
////                                BelongsTo::make('user'),
////                                Text::make('title'),
////                         ]),
//        );
//    }
    public function fields(): array
    {
        return [
                Block::make([

                ID::make()->sortable()->showOnExport(),
                Text::make('Заголовок', 'title')->showOnExport(),
                Text::make('Описание','description')->showOnExport(),
                Text::make("Текст",'text')->showOnExport(),
                Date::make("Дата публикации",'date')->showOnExport(),
                Image::make("Картинка",'image')->showOnExport(),
            ]),
        ];
    }

    /**
     * @param News $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
