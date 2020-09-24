<?php
/**
 * Contains the DateHelper class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-07
 *
 */

namespace Konekt\AppShell\Helpers;

use Carbon\Carbon;
use DateTimeInterface;
use Exception;
use Konekt\Gears\Facades\Preferences;

class DateHelper
{
    /**
     * @param \Carbon\Carbon|\DateTimeInterface|string|null $date
     * @param string                                        $unknownDateText
     * @param string|null                                   $format
     *
     * @return string
     */
    public function showDate($date, string $unknownDateText = '', string $format = null): string
    {
        $carbon = $this->toCarbon($date);

        if (null === $carbon) {
            return $unknownDateText;
        }

        $format = $format ?: Preferences::get('appshell.ui.date_format');

        if ('diff' === $format) {
            return $this->getDateDiff($carbon);
        }

        return $carbon->format($format);
    }

    /**
     * @param \Carbon\Carbon|\DateTimeInterface|string|null $datetime
     * @param string                                        $unknownDateTimeText
     * @param string|null                                   $format
     *
     * @return string
     */
    public function showDateTime($datetime, string $unknownDateTimeText = '', string $format = null): string
    {
        $carbon = $this->toCarbon($datetime);

        if (null === $carbon) {
            return $unknownDateTimeText;
        }

        $format = $format ?: Preferences::get('appshell.ui.datetime_format');

        if ('diff' === $format) {
            return $this->getDateDiff($carbon);
        }

        return $carbon->format($format);
    }

    /**
     * @param \Carbon\Carbon|\DateTimeInterface|string|null $datetime
     * @param string                                        $unknownTimeText
     * @param string|null                                   $format
     *
     * @return string
     */
    public function showTime($datetime, string $unknownTimeText = '', string $format = null): string
    {
        $carbon = $this->toCarbon($datetime);

        if (null === $carbon) {
            return $unknownTimeText;
        }

        $format = $format ?: Preferences::get('appshell.ui.time_format');

        if ('diff' === $format) {
            return $carbon->diffForHumans();
        }

        return $carbon->format($format);
    }

    private function getDateDiff(Carbon $date): string
    {
        if ($date->isToday()) {
            return __('Today');
        } elseif ($date->isYesterday()) {
            return __('Yesterday');
        }

        return $date->diffForHumans();
    }

    private function toCarbon($date): ?Carbon
    {
        if ($date instanceof Carbon || null === $date) {
            return $date;
        }

        if ($date instanceof DateTimeInterface) {
            return Carbon::instance($date);
        }

        if (is_string($date)) {
            try {
                return Carbon::parse($date);
            } catch (Exception $e) {
                return null;
            }
        }

        //if it's unknown
        return null;
    }
}
