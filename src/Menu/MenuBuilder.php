<?php
/**
 * Contains the MenuBuilder class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-01-27
 *
 */


namespace Konekt\AppShell\Menu;


use Illuminate\Support\Facades\Gate;
use Konekt\AppShell\Contracts\MenuBuilderInterface;

class MenuBuilder implements MenuBuilderInterface
{
    protected $menu;

    public function __construct($menu)
    {
        $this->menu = $menu;
    }

    /**
     * @inheritdoc
     */
    public function build(string $name)
    {
        $this->menu->make($name, function($menu) {
            $menu->add(__('Home'));

            if (Gate::allows('list.users')) {
                $menu->add(__('Users'), ['route' => 'user.index']);
            }

        });
    }


}