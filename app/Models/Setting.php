<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setSetting($data)
    {
        foreach ($data as $value) {
            $setting = $this->where('key', $value['key'])->first();
            if (!empty($setting)) {
                $setting->update($value);
            } else {
                $this->create($value);
            }
        }
    }

    public function getSetting($key)
    {
        return $this->where('key', $key)->value('value');
    }
}
