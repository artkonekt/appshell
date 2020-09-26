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

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Konekt\AppShell\Contracts\Asset;

class AssetCollection
{
    public const ASSET_FUNCTION_KEY = 'assetFunction';

    public const LOCATION_META_KEY  = '_location';

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

    public function scripts($location = null): Collection
    {
        $result = collect($this->scripts);

        if (null === $location) {
            return $result;
        }

        return $result->filter(function (Asset $item) use ($location) {
            return $location == $item->getMetaValue(self::LOCATION_META_KEY);
        });
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

    private static function makeAsset(string $class, $key, $value): Asset
    {
        if (is_numeric($key)) {
            $asset = new $class($value);
            $asset->addMetaValue(self::LOCATION_META_KEY, $asset::defaultLocation()->value());

            return $asset;
        }

        $assetFunction = array_key_exists(self::ASSET_FUNCTION_KEY, $value) ? $value[self::ASSET_FUNCTION_KEY] : BaseAsset::DEFAULT_ASSET_FUNCTION;
        $location      = Arr::get($value, self::LOCATION_META_KEY, $class::defaultLocation()->value());

        return new $class(
            $key,
            Arr::except($value, [self::ASSET_FUNCTION_KEY, self::LOCATION_META_KEY]),
            $assetFunction,
            [self::LOCATION_META_KEY => $location]
        );
    }
}
