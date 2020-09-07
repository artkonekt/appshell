<?php
/**
 * Contains the GeneratesSampleDateTimeOptions trait.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-07
 *
 */

namespace Konekt\AppShell\Preferences;

use Carbon\Carbon;

trait GeneratesSampleDateTimeOptions
{
    private function generateOptions(string $optionsConfigKey)
    {
        $sampleDate = Carbon::createFromTime('13', '01', '11');

        return collect($this->config($optionsConfigKey, [self::DEFAULT]))
            ->mapWithKeys(function ($format) use ($sampleDate) {
                return [
                    $format => 'diff' === $format
                        ? $sampleDate->diffForHumans()
                        : date($format, $sampleDate->timestamp)
                ];
            })->all();
    }
}
