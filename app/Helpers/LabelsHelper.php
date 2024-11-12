<?php

namespace App\Helpers;
use App\Models\Label;
use Illuminate\Support\Collection;

class LabelsHelper
{
    static ?Collection $labels = null;

    public static function __(string $key): string
    {
        if(is_null(self::$labels)){
            self::$labels = Label::all();
        }

        $label = self::$labels->where('value', $key)->first();

        if (!$label) {
            $label = Label::query()->create(['value' => $key, 'label' => $key]);

            self::$labels->push($label);
        }

        $label = self::$labels->where('value', $key)->first();

        $locale = app()->getLocale();

        if ($label->translations->where('locale', $locale)->first()) {
            return $label->translations->where('locale', $locale)->first()->value;
        }

        return addslashes(strip_tags($label->label));
    }
}
