<?php

namespace App\Enums;

enum Status: int
{
    case ENABLE = 1;
    case DISABLE = 0;

    public static function renderOption(int $status = 0, bool $ask = false): string
    {
        $enable  = (self::ENABLE)->value;
        $disable = (self::DISABLE)->value;

        $p_select = ($enable == $status)? "selected": "";
        $n_select = ($disable == $status)? "selected": "";

        $positive = $ask? _t("Yes"): _t("Enable");
        $negative = $ask? _t("No"):  _t("Disable");

        return "<option value=\"$enable\" $p_select>$positive</option>
                <option value=\"$disable\" $n_select>$negative</option>";
        
    }
}