<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Product\Manufacturer;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Text;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Metrics\ValueMetric;
use MoonShine\Resources\ModelResource;

class ManufacturerResource extends ModelResource
{
    protected string $model = Manufacturer::class;

    protected string $title = 'Manufacturers';
    protected string $sortDirection = 'ASC';
    public function metrics(): array
    {
        return [
            ValueMetric::make('Производители')
                ->value(Manufacturer::count()),
        ];
    }

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
                Text::make('Описание', 'short_description')->useOnImport(),
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
