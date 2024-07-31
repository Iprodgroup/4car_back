<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Product\Disk;
use App\Models\Product\Review;
use App\Models\Product\Tires;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Relationships\MorphTo;
use MoonShine\Fields\Text;
use MoonShine\Metrics\ValueMetric;
use MoonShine\Resources\ModelResource;

class ReviewResource extends ModelResource
{
    protected string $model = Review::class;

    protected string $title = 'Отзывы';

    const Tires = Tires::class;
    const Disk = Disk::class;
    public function fields(): array
    {
        return [
            Block::make([
                Text::make('Заголовок', 'title'),
                Text::make('Текст', 'text'),
                Text::make('Оценка', 'rating'),
                MorphTo::make('Товары', 'reviewable')->types([
                    self::Tires => 'name',
                    self::Disk => 'name',
                ]),
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
