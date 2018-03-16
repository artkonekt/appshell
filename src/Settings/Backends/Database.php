<?php
/**
 * Contains the Database settings backend class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-02-26
 *
 */


namespace Konekt\AppShell\Settings\Backends;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Database extends BaseBackend
{
    const TABLE_NAME = 'settings';

    /**
     * @inheritDoc
     */
    public function allSettings(): Collection
    {
        return DB::table(self::TABLE_NAME)
                 ->whereNull('user_id')
                 ->keyBy('key');
    }

    /**
     * @inheritDoc
     */
    public function allPreferences($user): Collection
    {
        return DB::table(self::TABLE_NAME)
                 ->where(['user_id' => $this->getUserId($user)])
                 ->keyBy('key');
    }

    /**
     * @inheritDoc
     */
    public function getSetting($setting)
    {
        return $this->get($setting);
    }

    /**
     * @inheritDoc
     */
    public function getPreference($setting, $user)
    {
        return $this->get($setting, $user);
    }

    /**
     * @inheritDoc
     */
    public function setSetting($setting, $value)
    {
        $this->set($setting, $value);
    }

    /**
     * @inheritDoc
     */
    public function setPreference($setting, $value, $user)
    {
        $this->set($setting, $value, $user);
    }

    protected function get($setting, $user = null)
    {
        $query = DB::table(self::TABLE_NAME)
                   ->select('value')
                   ->where('key', $this->getKey($setting)
                   );

        if ($user) {
            $query->where('user_id', $this->getUserId($user));
        }

        $result = $query->first();

        return $result ? $result->value : null;
    }

    protected function set($setting, $value, $user = null)
    {
        $lookup = [
            'key' => $this->getKey($setting)
        ];

        if ($user) {
            $lookup['user_id'] = $this->getUserId($user);
        }

        DB::table(self::TABLE_NAME)->updateOrInsert($lookup, [
            'value' => $value
        ]);
    }
}
