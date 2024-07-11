<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;

use MoonShine\Fields\Checkbox;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Feedback>
 */
class FeedbackResource extends ModelResource
{
    protected string $model = Feedback::class;

    protected string $title = 'Заявки обратной связи';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Имена','name'),
                Text::make('Номера','number'),
                Switcher::make('Обработан', 'is_handling')
                        ->onValue(1)
                        ->offValue(0)
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
