<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;


class FeedbackResource extends ModelResource
{
    protected string $model = Feedback::class;

    protected string $title = 'Заявки обратной связи';

    public function query(): Builder
    {
        return parent::query()
            ->where('is_handling', 0);
    }
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Имена','name'),
                Text::make('Номера','number'),
                Switcher::make('Статус', 'is_handling'),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
