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
use Konekt\AppShell\Contracts\Setting;
use Konekt\AppShell\Contracts\SettingsBackend;
use Konekt\User\Contracts\User;

class Database implements SettingsBackend
{
    const TABLE_NAME = 'settings';

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return DB::table(self::TABLE_NAME)->get();
    }

    /**
     * @inheritDoc
     */
    public function get(Setting $setting, $user = null)
    {
        $query = DB::table(self::TABLE_NAME)
                   ->select('value')
                   ->where('key', $setting->key()
                   );

        if ($user) {
            $query->where('user_id', $this->getUserId($user));
        }

        $result = $query->get();

        return $result->value;
    }

    /**
     * @inheritDoc
     */
    public function set(Setting $setting, $value, $user = null)
    {
        $lookup = [
            'key' => $setting->key()
        ];

        if ($user) {
            $lookup['user_id'] = $this->getUserId($user);
        }

        DB::table(self::TABLE_NAME)->updateOrInsert($lookup, [
            'value' => $value
        ]);
    }

    /**
     * Returns the user id based on dynamic user parameter
     *
     * @param User|int|null $user
     *
     * @return int|null
     */
    private function getUserId($user)
    {
        return $user instanceof User ? $user->id : $user;
    }


}
