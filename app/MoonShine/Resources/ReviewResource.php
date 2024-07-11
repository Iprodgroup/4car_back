<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Disk;
use App\Models\Tires;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use MoonShine\Fields\Relationships\MorphTo;
use MoonShine\Fields\Text;
use MoonShine\Metrics\ValueMetric;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;

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
