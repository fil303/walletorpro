<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View as ViewFactory;

if(!function_exists('countries')){

    /**
     * Get Country
     * @param string $nameByCode
     * @return array<string>|string
     */
    function countries(string $nameByCode = null): array|string
    {
        $countries = File::json(storage_path('countries.json'));

        if(!$nameByCode) return $countries;

        return $countries[strtoupper($nameByCode)] ?? "";
    }
}

if(!function_exists('countries_option')){

    /**
     * Get Country As Html Option
     * @param string $selectedOption
     * @return string
     */
    function countries_option(string $selectedOption = null): string
    {
        $countries = countries();

        $option = ViewFactory::make('user.components.select_option',[
            "items" => $countries,
            "seleted_item" => $selectedOption

        ])->render();

        return $option;
    }
}

if(!function_exists('countries_dial_code')){

    /**
     * Get Country Dial Code
     * @param string $country
     * @return array<string>|string
     */
    function countries_dial_code(string $country = null): array|string
    {
        $dial_codes = File::json(storage_path('countries_dial_code.json'));

        if(!$country) return $dial_codes;

        return $dial_codes[$country] ?? "";
    }
}