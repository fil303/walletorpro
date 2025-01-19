<?php

namespace App\Enums;

enum CoinBuyStatus: int
{
    case CANCELED = 3;
    case WAITING = 2;
    case COMPLETED = 1;
    case PENDING = 0;

    public static function getAll(int $index = null): array
    {
        return [
            (self::CANCELED)->value  => _t("Canceled"),
            (self::WAITING)->value   => _t("Waiting"),
            (self::COMPLETED)->value => _t("Completed"),
            (self::PENDING)->value   => _t("Pending"),
        ];
    }

    /**
     * Generate html option tags for select box to render on web page
     * @param string $coinBuyStatus
     * @return string
     */
    public static function renderOption(string $coinBuyStatus = ""): string
    {
        $coinBuyStatusAll = self::getAll();
        $html = "";

        foreach($coinBuyStatusAll as $coinBuyStatusKey => $coinBuyStatusValue){
            $key_select = ($coinBuyStatus == $coinBuyStatusKey)? "selected": "";
            $html .= "<option value=\"$coinBuyStatusKey\" $key_select>$coinBuyStatusValue</option>";
        }

        return $html;
    }

    public function status(): string
    {
        return match($this){
            self::CANCELED  => _t("Canceled"),
            self::WAITING   => _t("Waiting"),
            self::COMPLETED => _t("Completed"),
            self::PENDING   => _t("Pending"),
        };
    }
}