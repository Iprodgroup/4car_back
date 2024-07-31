<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Product\Comment;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;


class CommentResource extends ModelResource
{
    protected string $model = Comment::class;

    protected string $title = 'Комментарии';

    public function fields(): array
    {
        return [
            BelongsTo::make("Новости", "news", resource: new NewsResource()),
            BelongsTo::make("Пользователи", "user", resource: new UserResource()),

            Block::make([
                Text::make('Заголовок', "title"),
                Text::make('Текст', "body"),
            ]),
        ];
    }

    /**
     * @param Comment $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
