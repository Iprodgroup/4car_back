<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Product\Manufacturer;
use App\Models\Product\Order;
use App\Models\User;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Decorations\Divider;
use MoonShine\Metrics\LineChartMetric;
use MoonShine\Metrics\ValueMetric;
use MoonShine\Pages\Page;

class Dashboard extends Page
{
    /**
     * @return array<string, string>
     */
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return $this->title ?: 'Главная панель';
    }

    /**
     * @return list<MoonShineComponent>
     */
    public function components(): array
	{
        return [

            ValueMetric::make('Производители')
            ->value(Manufacturer::count())
            ->columnSpan(6),
            Divider::make(' '),

            ValueMetric::make('Пользователи')
            ->value(User::count())
            ->columnSpan(6),
            Divider::make(' '),

            ValueMetric::make('Заказы')
            ->value(Order::count())
            ->columnSpan(6),
            Divider::make(' '),

            LineChartMetric::make('Заказы')
                ->line([
                    'Profit' => User::query()
                        ->groupBy('id')
                        ->pluck('id')
                        ->toArray()
                ])
        ];
	}




}
