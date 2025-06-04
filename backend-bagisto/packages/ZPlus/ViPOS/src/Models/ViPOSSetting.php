<?php

namespace ZPlus\ViPOS\Models;

use Illuminate\Database\Eloquent\Model;

class ViPOSSetting extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'vipos_settings';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get a setting value by key.
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value by key.
     */
    public static function setValue(string $key, $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get multiple settings by keys.
     */
    public static function getValues(array $keys): array
    {
        $settings = static::whereIn('key', $keys)->get();
        
        $result = [];
        foreach ($keys as $key) {
            $setting = $settings->firstWhere('key', $key);
            $result[$key] = $setting ? $setting->value : null;
        }
        
        return $result;
    }
}