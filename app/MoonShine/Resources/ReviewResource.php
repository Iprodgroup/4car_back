<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Review;

use MoonShine\Fields\Text;
use MoonShine\Metrics\ValueMetric;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

class ReviewResource extends ModelResource
{
    protected string $model = Review::class;

    protected string $title = 'Отзывы';


    public function fields(): array
    {
        return [
            Block::make([
                Text::make('Товар', 'title')

            ]),
        ];
    }

    public function metrics(): array
    {
        return [
            ValueMetric::make('Отзывы')
                ->value(Review::count()),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
