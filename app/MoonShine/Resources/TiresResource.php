<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tires;

use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\MorphMany;
use MoonShine\Fields\Text;
use MoonShine\Metrics\ValueMetric;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Tires>
 */
class TiresResource extends ModelResource
{
    protected string $model = Tires::class;

    protected string $title = 'Шины';
    protected string $sortDirection = 'ASC';

    public function metrics(): array
    {
        return [
            ValueMetric::make('Шины')
                ->value(Tires::count()),
        ];
    }
    public function fields(): array
    {
        return [
            Block::make([
                Image::make('Изображение','image'),
                Text::make('Название','name'),
                Number::make('Цена', 'price'),
                Number::make('Количество'),
                MorphMany::make('Отзывы', 'reviews')->onlyLink(),
            ]),

        ];
    }

    /**
     * @param Tires $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
