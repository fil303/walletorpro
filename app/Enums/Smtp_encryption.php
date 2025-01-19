<?php

namespace App\Enums;

enum Smtp_encryption: string
{
    case TLS = "TLS";
    case SSL = "SSL";


    public static function getAll(): array
    {
        return [
            (self::TLS)->value => _t("TLS"),
            (self::SSL)->value => _t("SSL"),
        ];
    }

    public static function renderOption(string $pageParam = ""): string
    {
        $pages = self::getAll();
        $html = "";

        foreach($pages as $page => $pageName){
            $page_select = ($pageParam == $page)? "selected": "";
            $html .= "<option value=\"$page\" $page_select>$pageName</option>";
        }

        return $html;
    }
}