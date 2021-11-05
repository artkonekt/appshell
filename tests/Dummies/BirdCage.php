<?php

declare(strict_types=1);

/**
 * Contains the BirdCage class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-10-05
 *
 */

namespace Konekt\AppShell\Tests\Dummies;

class BirdCage
{
    public int $id = 2021;

    public Parrot $parrot;

    public function __construct(string $parrotName, string $link)
    {
        $this->parrot = new Parrot($parrotName, $link);
    }
}
