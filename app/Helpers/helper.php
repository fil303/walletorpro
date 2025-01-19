<?php

use App\Models\Coin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

require_once(__DIR__.'/countries.php');

if(!function_exists('logStore')){
    /**
     * logStore will save site logs.
     *
     * @param string $message
     * @param mixed $context
     * @param string $level
     * @return void
     */
    function logStore($message, $context = [], $level = "error"): void
    {
        if(gettype($context) != "array"){
            $context = [!empty($context) ? $context : ""];
        }
        Log::log($level, $message, $context);
    }
}


if(!function_exists('enum')){
    /**
     * enum function will extract value of Enum Class.
     *
     * @param mixed $enumClass
     * @return mixed
     */
    function enum($enumClass): mixed
    {
        return $enumClass?->value;
    }
}


if(!function_exists('get_settings')){
    /**
     * get_settings function will extract site_settings data form db or cache.
     *
     * @param string $slug
     * @return mixed
     */
    function get_settings($slug = null): mixed
    {
        try{
            $settings = null;
            if(!Cache::has('siteSettings'))
            {
                $settings = DB::table("site_settings")->get()->toSlugValue();
                Cache::put('siteSettings', $settings, (60 * 60));
            }else{
                $settings = Cache::get('siteSettings');
            }
            if(gettype($slug) == "array")
            {
                dd($slug);
            }
            if($slug != null) return $settings->$slug ?? null;
            return $settings;
        }catch(\Exception $e)
        {
            dd("helper exception error",$e->getLine() .'\n' . $e->getMessage() .'\n'.$e->getTraceAsString());
        }

    }
}


if(!function_exists('makeResponse')){
    /**
     * Make Response To Return
     * @param bool $status
     * @param string $message
     * @param mixed $data
     * @return array<string, mixed>
     */
    function makeResponse(bool $status = false, string $message = null, mixed $data = []): array
    {
        try{
            $response = [];
            if($message === null) 
            $message = _t("Something went wrong");
            $response['status'] = $status;
            $response['message'] = $message;
            if(!empty($data)){
                if(is_array($data))
                $response['data'] = $data;
                else $response['data'] = [$data];
            }
            return $response;
        }catch(\Exception $e) { // should remove try catch statement
            logStore("helper makeResponse",$e->getMessage());
            return ["status" => false, "message" => _t("Something went wrong"), "data" => []];
        }

    }
}


if(!function_exists('uniqueCode')){
    /**
     * uniqueCode function create unique id for db record.
     *
     * @param string $prefix
     * @return string
     */
    function uniqueCode(string $prefix = "", bool $integer = false):string
    {
        $randValue  = $prefix;
        $randValue .= $integer ? "" : uniqid() ;
        return $randValue.strtotime(date('Y-m-d H:s:i'));
    }
}


if(!function_exists('user_id')){
    /**
     * user_id function is current user id.
     *
     * @return int
     */
    function user_id(): int
    {
        return (int) (Auth::id() ?? 0);
    }
}

if(!function_exists('random_str')){
    /**
     * user_id function is current user id.
     *
     * @param string $prefix
     * @param int<1, max> $length
     * @return string
     */
    function random_str(string $prefix = "", int $length = 32): string
    {
        $bytes = random_bytes($length);
        $str = bin2hex($bytes);
        return substr("$prefix$str", 0, $length);
    }
}

if(!function_exists('to_coin')){
    /**
     * to_coin function is to make a big number to regular number.
     *
     * @param int $amount
     * @param int $decimal
     * @return string
     */
    function to_coin(int $amount, int $decimal = 18): string
    {
        $decimal_ = (int) pow(10, $decimal);
        $coin_amount = (float) $amount / $decimal_;

        // if(is_finite($coin_amount)){
        //     return trim_number(number_format($coin_amount, $decimal, ".", ""));
        // }

        // return trim_number($coin_amount);
        return trim_number(number_format($coin_amount, $decimal, ".", ""));
    }
}

if(!function_exists('to_decimal')){
    /**
     * to_decimal function is to make a number to big integer.
     *
     * @param float $amount
     * @param int $decimal
     * @return int
     */
    function to_decimal(float $amount, int $decimal = 18): int
    {
        $decimals = (int) pow(10, $decimal);
        $crypto_amount =(float) $amount * $decimals;

        // if(is_int($crypto_amount))
        //     return $crypto_amount;

        if(is_finite($crypto_amount))
            return (int) number_format($crypto_amount, $decimal, ".", "");

        return (int) $crypto_amount;
    }
}

if(!function_exists('asset_bind')){
    /**
     * asset_bind function is to bind asset and set prefix .
     *
     * @param string $path
     * @param string $prefix
     * @return string
     */
    function asset_bind(string $path, string $prefix = ""): string
    {
        $prefix = env("ASSET_BIND_PREFIX" ,$prefix);
        $path   = ($path[0] ?? '') == "/" ? substr($path, 1) : $path;
        return asset("$prefix/$path");
    }
}

if(!function_exists('return_number')){
    /**
     * return_number function is to ensure callback return string numeric .
     *
     * @param mixed $callback
     * @return string
     */
    function return_number(mixed $callback): string
    {
        $return_value = $callback();

        if(is_finite($return_value)){
            return trim_number(number_format($return_value, 14, ".", ""));
        }

        return $return_value;
    }
}

if(!function_exists('trim_number')){
    /**
     * trim_number function is to trim unnecessary 0.
     *
     * @param string $num
     * @return string
     */
    function trim_number(string $num): string
    {
        if(is_numeric($num)){
            $num_set   = explode('.', $num);
            $num_first = preg_replace('%^[0]+%', "", $num_set[0] ?? "");
            $num_second= preg_replace('%[0]+$%', "", $num_set[1] ?? "");
            return ($num_first == "" ?"0": $num_first).($num_second == "" ? "": ".$num_second");
        }
        return '0';
    }
}

if(!function_exists('safe_code')){
    /**
     * safe_code function is to to get throw message.
     *
     * @param callable $callback
     * @return mixed
     */
    function safe_code(callable $callback): mixed
    {
        try {
            $response = $callback();
            return success(_t("Exicuted"), [ "result" => $response ]);
        } catch (\Exception $e) {
            return failed($e->getMessage());
        }
    }
}

if (!function_exists('_t')) {
    /**
     * Translate the given message.
     *
     * @param  string  $key
     * @param  array<mixed>  $replace
     * @param  string|null  $locale
     * @return string
     */
    function _t(string $key, array $replace = [], ?string $locale = null)
    {
        $trans = trans($key, $replace, $locale);

        if(gettype($trans) == 'string') return $trans;
        return "";
    }
}

if (!function_exists('numberShortFormat')) {
    /**
     * Translate the given message.
     *
     * @param int|float|string $number
     * @return string
     */
    function numberShortFormat(int|float|string $number): string
    {
        if ($number >= 1e12) {
            return number_format(((float) $number) / 1e12, 2) . ' T';
        } else if ($number >= 1e9) {
            return number_format(((float) $number) / 1e9, 2) . ' B';
        } else if ($number >= 1e6) {
            return number_format(((float) $number) / 1e6, 2) . ' M';
        } else if ($number >= 1e3) {
            return number_format(((float) $number) / 1e3, 2) . ' K';
        } else {
            return number_format(((float) $number), 2); 
        }
    }
}

if (! function_exists('success')) {

    /**
     * Generate success response array
     * @param mixed $messageOrData
     * @param mixed $data
     * @param array<string, mixed> $topLevelData
     * @return array<mixed>
     */
    function success(mixed $messageOrData = null, mixed $data = [], array $topLevelData = []): array
    {
        $response = [];
        
        if($messageOrData === null) 
            $messageOrData = _t("Success");
    
        if(gettype($messageOrData) !== 'string'){
            $data = $messageOrData;
            $messageOrData = _t("Success");
        }
        $response['status'] = true;
        $response['message'] = $messageOrData;

        if(!empty($data)){
            $response['data'] = is_array($data) ? $data : [$data];
        }

        foreach($topLevelData as $key => $value){
            $response[$key] = $value;
        }

        return $response;
    }
}

if (! function_exists('failed')) {

    /**
     * Generate failed response array
     * @param mixed $messageOrData
     * @param mixed $data
     * @param array<string, mixed> $topLevelData
     * @return array<mixed>
     */
    function failed(mixed $messageOrData = null, mixed $data = [], array $topLevelData = []): array
    {
        if($messageOrData === null) 
            $messageOrData = _t("Failed");
    
        if(gettype($messageOrData) !== 'string'){
            $data = $messageOrData;
            $messageOrData = _t("Failed");
        }

        $response = success($messageOrData, $data, $topLevelData);
        $response['status'] = false;

        return $response;
    }
}

if (! function_exists('is_success')) {

    /**
     * Check is response success
     * @param array<string> $response
     * @return bool
     */
    function is_success(array $response): bool
    {
        return !!($response['status'] ?? false);
    }
}

if (! function_exists('print_coin')) {

    /**
     * Print Coin As Decimal Set In Coin
     * @param mixed $amount
     * @param int $decimal
     * @return string
     */
    function print_coin(mixed $amount, int $decimal = 8): string
    {
        return number_format($amount, $decimal, '.', '');
    }
}

if (! function_exists('currency_convert')) {

    /**
     * Convert coin rate
     * @param App\Models\Coin $from
     * @param App\Models\Coin|null $to
     * @param float $amount
     * @return float
     */
    function currency_convert(Coin $from, Coin $to = null, float $amount): float
    {
        $rate = $from->rate;
        $amount *= $rate;
        $convert_amount = $amount / ($to->rate ?? 1); // 1 USDT is default
        return $convert_amount;
    }
}

if (! function_exists('generate_unique_slug')) {

    function generate_unique_slug(string $title): string
    {
        $table = [
            'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
            'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
            'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
            'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b',
            'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r', '/' => '-', ' ' => '-'
        ];

        $slug = strtolower(strtr($title, $table));
        $slug = str_replace("?", "", $slug);
        return $slug;
    }
}