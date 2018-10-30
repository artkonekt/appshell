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
    /** @var array */
    protected $scripts = [];

    /** @var array */
    protected $stylesheets = [];

    public static function createFromArray(array $config): self
    {
        $result = new static();

        foreach ($config['js'] ?? [] as $key => $value) {
            if (is_numeric($key)) {
                $result->addScript(new Script($value));
            } else {
                $result->addScript(new Script($key, $value));
            }
        }

        foreach ($config['css'] ?? [] as $key => $value) {
            if (is_numeric($key)) {
                $result->addStylesheet(new Stylesheet($value));
            } else {
                $result->addStylesheet(new Stylesheet($key, $value));
            }
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
}
