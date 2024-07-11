<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\CommentResource;
use App\MoonShine\Resources\DiskResource;
use App\MoonShine\Resources\ManufacturerResource;
use App\MoonShine\Resources\NewsResource;
use App\MoonShine\Resources\OrderResource;
use App\MoonShine\Resources\ReviewResource;
use App\MoonShine\Resources\TiresResource;
use App\MoonShine\Resources\UserResource;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;
use MoonShine\Contracts\Resources\ResourceContract;

use Closure;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    /**
     * @return list<ResourceContract>
     */
    protected function resources(): array
    {
        return [];
    }


    protected function pages(): array
    {
        return [];
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make(static fn() => __('moonshine::ui.resource.system'), [
                MenuItem::make(
                    static fn() => __('moonshine::ui.resource.admins_title'),
                    new MoonShineUserResource()
                ),
                MenuItem::make(
                    static fn() => __('moonshine::ui.resource.role_title'),
                    new MoonShineUserRoleResource()
                ),
            ]),

            MenuGroup::make('Пользователи', [
                MenuItem::make('Пользователи',
                new UserResource())
            ]),
            MenuGroup::make('Производители', [
                MenuItem::make('Производители',
                new ManufacturerResource())
            ]),
            MenuGroup::make('Заказы', [
                MenuItem::make('Заказы',
                    new OrderResource())
            ]),
            MenuGroup::make('Товары', [
                MenuItem::make('Диски',
                    new DiskResource()),
                MenuItem::make('Шины',
                    new TiresResource()),
            ]),
            MenuGroup::make('Отзывы', [
                MenuItem::make('Отзывы',
                    new ReviewResource())
            ]),
            MenuGroup::make('Новости',[
                MenuItem::make('Новости',
                    new NewsResource())
            ]),
            MenuGroup::make('Комментарии', [
                MenuItem::make('Комментарии',
                    new CommentResource())
            ]),
        ];
    }


    protected function theme(): array
    {
        return [];
    }
}
