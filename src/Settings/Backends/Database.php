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
    public function all(): Collection
    {
        return DB::table(self::TABLE_NAME)->get()->keyBy(function($item) {
            return $item->key . ($item->user_id ? self::USER_KEY_SEPARATOR . $item->user_id : '');
        });
    }

    /**
     * @inheritDoc
     */
    public function get($setting, $user = null)
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

    /**
     * @inheritDoc
     */
    public function set($setting, $value, $user = null)
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
