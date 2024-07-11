<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Disk;

use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\Text;
use MoonShine\Metrics\ValueMetric;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Disk>
 */
class DiskResource extends ModelResource
{
    protected string $model = Disk::class;

    protected string $title = 'Диски';
    protected string $sortDirection = 'ASC';
    public function metrics(): array
    {
        return [
            ValueMetric::make('Диски')
                ->value(Disk::count()),
        ];
    }
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Image::make('Изображение', 'image'),
                Text::make('Название', 'name'),
                Number::make('Цена', 'price'),
                Number::make('Количество'),

            ]),
        ];
    }

    /**
     * @param Disk $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
