<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class HelperService
{
//    public static function getTransactionNo($lastDataInc = null, $length = 5)
//    {
//        $formattedData = str_pad(rand(111, 999), $length, '0', STR_PAD_LEFT);
//
//        return Carbon::now()->format('y') . $formattedData;
//    }

//    public static function slackErrorMessage($message, $e): void
//    {
//        \Log::channel('slack')->critical(env('SLACK_USERNAME', 'Anonymous Dev') . ' : ' . $message . " \n" . $e);
//    }

    public static function getTokenLifeTime()
    {
        return Carbon::now()->addMinutes(env('TOKEN_EXPIRE_IN'));
    }

    public static function getMAxItemLimit($itemPerPage = 50)
    {
        $request = app('request');

        if ($request->has('per_page')) {
            return $request->per_page > 500 ? 500 : $request->per_page;
        }
        return $itemPerPage;
    }

    public static function getSortKeyVal($str): object
    {
        $words = explode('_', $str);

        $sortType = array_pop($words);

        validator(['sort_type' => $sortType], ['sort_type' => 'nullable|string|in:asc,desc'])->validate();

        return (object)[
            'sort_type' => $sortType,
            'sort_key' => implode('_', $words),
        ];
    }

    public static function nl2li($input)
    {
        // New line to list item
        $convert = explode('<br />', nl2br($input));
        $final = '';
        foreach ($convert as $value) {
            $final .= '<li>' . $value . '</li>';
        }
        return $final;
    }


    public static function formattedTitle($item, $key = 'title')
    {
        $currentLang = Config::get('app.locale');

        return $currentLang == 'bn' ? $item[$key .'_bn'] : $item[$key.'_en'];
    }

    public static function formattedArrayTitle($collection): string
    {
        return Config::get('app.locale') == 'bn' ? implode(', ', $collection->pluck('title_bn')->toArray()) : implode(', ', $collection->pluck('title_en')->toArray());
    }


    public static $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর");
    public static $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "Jan", "Feb", "Mar", 'Apr', "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

    public static function bn2en($number)
    {
        return str_replace(self::$bn, self::$en, $number);
    }

    public static function en2bn($number)
    {
        return str_replace(self::$en, self::$bn, $number);
    }

    public static function formattedNumber($value)
    {
        return Config::get('app.locale') == 'bn' ? self::en2bn($value) : self::bn2en($value);
    }

    public static function extractKeywords($string){
        return explode(' ', $string);
    }
}
