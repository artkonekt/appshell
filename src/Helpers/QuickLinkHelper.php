<?php
/**
 * Contains the QuickLinkHelper class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-09
 *
 */

namespace Konekt\AppShell\Helpers;

use Konekt\AppShell\Preferences\QuickLinksPreference;
use Konekt\Gears\Facades\Preferences;

class QuickLinkHelper
{
    public function links(): array
    {
        return json_decode(Preferences::get(QuickLinksPreference::KEY), true);
    }

    public function update(array $links): void
    {
        Preferences::set(QuickLinksPreference::KEY, json_encode($links));
    }
}
