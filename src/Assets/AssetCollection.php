<?php
/**
 * Contains the AssetCollection class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-10-30
 *
 */

namespace Konekt\AppShell\Assets;

use Illuminate\Support\Collection;

class AssetCollection
{
    const ASSET_FUNCTION_KEY = 'assetFunction';

    /** @var array */
    protected $scripts = [];

    /** @var array */
    protected $stylesheets = [];

    public static function createFromArray(array $config): self
    {
        $result = new static();

        foreach ($config['js'] ?? [] as $key => $value) {
            $result->addScript(self::makeScript($key, $value));
        }

        foreach ($config['css'] ?? [] as $key => $value) {
            $result->addStylesheet(self::makeStylesheet($key, $value));
        }

        return $result;
    }

    public function scripts(): Collection
    {
        return collect($this->scripts);
    }

    public function stylesheets(): Collection
    {
        return collect($this->stylesheets);
    }

    protected function addScript(Script $script)
    {
        $this->scripts[] = $script;
    }

    private function addStylesheet(Stylesheet $stylesheet)
    {
        $this->stylesheets[] = $stylesheet;
    }

    private static function makeScript($key, $value): Script
    {
        return self::makeAsset(Script::class, $key, $value);
    }

    private static function makeStylesheet($key, $value): Stylesheet
    {
        return self::makeAsset(Stylesheet::class, $key, $value);
    }

    private static function makeAsset(string $class, $key, $value): BaseAsset
    {
        if (is_numeric($key)) {
            return new $class($value);
        } elseif (array_key_exists(self::ASSET_FUNCTION_KEY, $value)) {
            return new $class(
                $key,
                array_except($value, self::ASSET_FUNCTION_KEY),
                $value[self::ASSET_FUNCTION_KEY]
            );
        }

        return new $class($key, $value);
    }
}
