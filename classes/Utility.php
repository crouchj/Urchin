<?php

class Utility {

    public static function slugify($string) {
        $string = preg_replace("/[^0-9a-zA-Z ]/m", "", $string);
        $string = preg_replace("/ /", "-", $string);
        $string = str_replace("--", "-", $string);
        return strtolower($string);
    }

    public static function firstParagraph($text, $append = false) {
        // strip empty <p> tags
        $text = preg_replace("#<p>(\s|&nbsp;|</?\s?br\s?/?>)*</?p>#", "", $text);

        // get the first <p> tag
        if (preg_match('%(<p[^>]*>.*?</p>)%i', $text, $regs)) {
            $text = $regs[1];
            if ($append) {
                $text = rtrim(substr($text, 0, strpos($text, "</p>")), '.') . $append . '</p>';
            }
        } else {
            // otherwise strip all tags and get the first 275 characters
            $text = Utility::trimText(strip_tags($text), 275, $append);
            $text = '<p>' . $text . '</p>';
        }

        return $text;
    }

    public static function trimText($text, $length = 80, $append = '...') {
        if (strlen($text) > $length) {
            $last_space = strrpos(substr($text, 0, $length), ' ');
            $text = substr($text, 0, $last_space);
            $text .= $append;
        }
        return $text;
    }

    public static function timeAgo($date, $granularity = 1) {
        $difference = time() - $date;
        $periods = array(
            'decade' => 315360000,
            'year'   => 31536000,
            'month'  => 2628000,
            'week'   => 604800,
            'day'    => 86400,
            'hour'   => 3600,
            'minute' => 60,
            'second' => 1
        );
        $retval = '';
        foreach ($periods as $key => $value) {
            if ($difference >= $value) {
                $time = floor($difference/$value);
                $difference %= $value;
                $retval .= ($retval ? ' ' : '').$time.' ';
                $retval .= (($time > 1) ? $key.'s' : $key);
                $granularity--;
            }
            if ($granularity == '0') {
                break;
            }
        }
        return ' posted ' . $retval . ' ago';
    }

    public static function cleanURL($url) {
        if (strpos($url, "http://") !== 0 && strpos($url, "https://") !== 0) {
            $url =  "http://" . $url;
        }
        return $url;
    }

    public static function redirectTo404() {
        unset($_GET['destination']);
        drupal_goto('404-page-not-found');
    }
}