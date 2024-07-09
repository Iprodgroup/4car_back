<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Manufacturer;

use MoonShine\Fields\Image;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Text;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Support\Filters;

/**
 * @extends ModelResource<Manufacturer>
 */
class ManufacturerResource extends ModelResource
{
    protected string $model = Manufacturer::class;

    protected string $title = 'Manufacturers';

    public function import(): ?ImportHandler
    {
        return ImportHandler::make('Import')->disk('public');
    }
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable()->useOnImport(),
                Text::make('Название', 'name')->useOnImport(),
                Text::make('Описание', 'description')->useOnImport(),
                Slug::make('Slug')
                    ->from('name')
                    ->separator('-')
                    ->unique(),
                Image::make('Изображение','picture')->useOnImport(),
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
        return [

        ];
    }
}
