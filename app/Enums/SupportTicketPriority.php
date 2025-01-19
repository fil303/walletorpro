<?php

namespace App\Enums;

enum SupportTicketPriority: string
{
    case HIGH = 'high';
    case MEDIUM = 'medium';
    case LOW = 'low';

    /**
     * This method will return all enum case as array
     * @return array<string, string>
     */
    public static function getAll(): array
    {
        return [
            (self::HIGH)->value   => _t("High"),
            (self::MEDIUM)->value => _t("Medium"),
            (self::LOW)->value    => _t("Low"),
        ];
    }

    public static function renderOption(string $param_priority = ""): string
    {
        $priorities = self::getAll();
        $html = "";

        foreach($priorities as $value => $priority){
            $priority_select = ($param_priority == $value)? "selected": "";
            $html .= "<option value=\"$value\" $priority_select>$priority</option>";
        }

        return $html;
    }
}