<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use MoonShine\Fields\Email;
use MoonShine\Fields\Text;
use MoonShine\Metrics\ValueMetric;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

class UserResource extends ModelResource
{
    protected string $model = User::class;
    protected string $column = 'email';
    protected string $title = 'Пользователи';
    protected string $sortDirection = 'ASC';

    public function search(): array
    {
        return ['id', 'first_name', 'last_name', 'email'];
    }

    public function fields(): array
    {

        return [
            Block::make([
//                ID::make()->sortable()->showOnExport(),
                Text::make('Имя', "first_name")->showOnExport(),
                Text::make('Фамилия', "last_name")->showOnExport(),
                Email::make('Email', "email")->showOnExport(),
            ]),
        ];
    }

    public function metrics(): array
    {
        return [
            ValueMetric::make('Пользователи')
                ->value(User::count()),
        ];
    }
    public function rules(Model $item): array
    {
        return [];
    }
}
