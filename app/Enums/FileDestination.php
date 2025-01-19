<?php

namespace App\Enums;

enum FileDestination: string
{
    case APP_LOGO_PATH = "logo/";
    case APP_IMAGE_PATH = "images/";
    case PROFILE_IMAGE_PATH = "profile/";
    case COIN_ICON_PATH = "coin/";
    case TICKET_ATTACHMENT_PATH = "files/ticket/";

    /**
     * Get Storage Path
     * @return string
     */
    public function storagePath(): string
    {
        $value = $this->value;
        $size = strlen($this->value);
        $lastIndex = $this->value[$size - 1];

        if($lastIndex == "/") {
            /** @var string $value */
            $value = substr_replace(
                string : $this->value,
                replace: "",
                offset : $size - 1,
                length : 1
            );
        }
        return $value;
    }
}