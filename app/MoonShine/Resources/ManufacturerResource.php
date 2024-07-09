<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Manufacturer;

use MoonShine\Fields\Image;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Manufacturer>
 */
class ManufacturerResource extends ModelResource
{
    protected string $model = Manufacturer::class;

    protected string $title = 'Manufacturers';

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Название', 'name'),
                Text::make('Описание', 'description'),
                Slug::make('Slug', 'slug'),
                Image::make('Изображение','picture'),
            ]),
        ];
    }

    /**
     * @param Manufacturer $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
