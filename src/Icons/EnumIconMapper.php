<?php
/**
 * Contains the EnumIcon class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-02
 *
 */


namespace Konekt\AppShell\Icons;

use Konekt\Enum\Enum;

class EnumIconMapper
{
    /** @var array */
    protected $map = [];

    /**
     * Register icon mapping for a specific enum class
     *
     * @param string $enumClass
     * @param array  $icons
     */
    public function registerEnumIcons($enumClass, array $icons)
    {
        $this->map = array_merge($this->map, [shorten($enumClass) => $icons]);
    }

    /**
     * Returns the icon for the given enum instance
     *
     * @param Enum $enum
     *
     * @return mixed
     */
    public function icon(Enum $enum)
    {
        return array_get(
            $this->map,
            sprintf('%s.%s', shorten(get_class($enum)), $enum->value()),
            config('konekt.app_shell.icon.default', 'default')
        );
    }
}
