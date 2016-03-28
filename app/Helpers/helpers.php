<?php
/**
 * Created by PhpStorm.
 * User: jbauer
 * Date: 3/10/2016
 * Time: 10:23 AM
 */

class Helper
{
    public static function modify_url($mod, $url = FALSE)
    {
        // If $url wasn't passed in, use the current url
        if ($url == FALSE) {
            $scheme = $_SERVER['SERVER_PORT'] == 80 ? 'http' : 'https';
            $url = $scheme . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }

        // Parse the url into pieces
        $url_array = parse_url($url);

        // The original URL had a query string, modify it.
        if (!empty($url_array['query'])) {
            parse_str($url_array['query'], $query_array);
            foreach ($mod as $key => $value) {
//                if (!empty($query_array[$key])) {
                if(1){
                    $query_array[$key] = $value;
                }
            }
        } // The original URL didn't have a query string, add it.
        else {
            $query_array = $mod;
        }

        return url($url_array['path'] . '?' . http_build_query($query_array));
    }
}