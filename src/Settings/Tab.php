<?php
/**
 * Contains the Tab class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-13
 *
 */


namespace Konekt\AppShell\Settings;


use Konekt\AppShell\Contracts\SettingsTab;

class Tab implements SettingsTab
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $label;

    /** @var int */
    protected $order;

    public function __construct(string $id, string $label, int $order = null)
    {
        $this->id    = $id;
        $this->label = $label;
        $this->order = $order;
    }

    /**
     * @inheritDoc
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function label(): string
    {
        return $this->label;
    }

    /**
     * @inheritDoc
     */
    public function order()
    {
        return $this->order;
    }

    /**
     * @inheritDoc
     */
    public function allowed(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function permission()
    {
        return null;
    }
}
