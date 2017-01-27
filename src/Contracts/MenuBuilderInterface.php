<?php
/**
 * Contains the MenuBuilder interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-01-27
 *
 */


namespace Konekt\AppShell\Contracts;


interface MenuBuilderInterface
{
    /**
     * Build a menu with a given name
     *
     * @param string $name
     *
     * @return void
     */
    public function build(string $name);

}