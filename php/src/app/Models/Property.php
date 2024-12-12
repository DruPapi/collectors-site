<?php

namespace App\Models;

use App\Models\Abstracts\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property query()
 *
 * @mixin \Eloquent
 */
class Property extends Model
{
    const HOME_CONTENT_NAME = 'home_content';

    protected $table = 'properties';

    public static function getProperty(string $name): ?self
    {
        return self::query()
            ->where('name', '=', $name)
            ->first();
    }

    public static function getValue(string $name): string
    {
        return self::getProperty($name)->description ?? '';
    }

    public static function setValue(string $name, string $value): void
    {
        self::firstOrNew(['name' => $name], ['name' => $name])
            ->fill(['value' => $value])
            ->save();
    }
}
