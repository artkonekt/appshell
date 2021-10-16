<?php

declare(strict_types=1);

/**
 * Contains the Link class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Widgets;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Traits\RendersThemedWidget;
use Konekt\AppShell\Traits\ResolvesSubstitutions;
use Konekt\AppShell\Widgets;

class Link implements Widget
{
    use RendersThemedWidget;
    use ResolvesSubstitutions;

    protected static $allowedOptions = [
        'onlyIfCan',
    ];

    private static array $canCache = [];

    /** @var callable */
    protected $url;

    protected Text $text;

    protected $options = [];

    public function __construct(Theme $theme, Text $text, callable $url)
    {
        $this->theme = $theme;
        $this->url = $url;
        $this->text = $text;
    }

    public static function create(Theme $theme, array $options = []): Link
    {
        $text = is_array($options['text']) ? $options['text'] : ['text' => $options['text'] ?? null];
        $instance = new static(
            $theme,
            Widgets::make('text', $text, $theme),
            self::makeCallable($options['url'] ?? null),
        );

        foreach (self::$allowedOptions as $allowedOption) {
            if (isset($options[$allowedOption])) {
                $instance->options[$allowedOption] = $options[$allowedOption];
            }
        }

        return $instance;
    }

    public function render($data = null): string
    {
        $url = $this->url;
        return $this->renderViewFromTheme('link', array_merge($this->options, [
            'can' => $this->can(),
            'text' => $this->text->render($data),
            'url' => $url($data, $this),
        ]));
    }

    private function can(): bool
    {
        $permission = $this->options['onlyIfCan'] ?? null;
        if (null === $permission) {
            return true;
        }

        if (!isset(self::$canCache[Auth::user()->id][$permission])) {
            self::$canCache[Auth::user()->id][$permission] = Auth::user()->can($permission);
        }

        return self::$canCache[Auth::user()->id][$permission];
    }
}
