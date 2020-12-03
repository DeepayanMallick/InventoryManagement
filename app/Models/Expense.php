<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = date("Y-m-d", strtotime($date));
    }

    public function getDateAttribute($date)
    {
        return date("d-m-Y", strtotime($date));
    }

    public function getTypeAttribute($type)
    {
        if ($type == 'salary') {
            return 'Salary';
        } else if ($type == 'miscellaneous') {
            return 'Miscellaneous';
        } else if ($type == 'raw-material') {
            return 'Raw Material';
        } else {
            return null;
        }
    }
}
