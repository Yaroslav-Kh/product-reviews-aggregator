<?php

use Engine\Libraries\UrlManager;

if (! function_exists('loadFile')) {


	function loadFile($type,$file, $filetype = '.php') {
		switch ($type) {
			case $type === 'app':
				$type = APP;
				break;
			case $type === 'config':
				$type = CONFIG;
				break;
			case $type === 'engine':
				$type = ENGINE;
				break;
		}

		return include ($type . $file . $filetype);
	}

}

if (! function_exists('redirect')) {

    function redirect($url)
    {
        if ($url == '/') {
            $url = '';
        }

        header('Location:' . UrlManager::makeUrl($url));
    }

}

if (! function_exists('back')) {

    function back()
    {
		if (isset($_SERVER["HTTP_REFERER"])) {
			header('Location:'.$_SERVER["HTTP_REFERER"] );
		}
    }

}

if (! function_exists('public_image')) {

    function public_image($file)
    {
		return IMAGE .  $file;
    }

}

if (! function_exists('image')) {

    function image($file)
    {

        $request = new \Engine\Core\Request();

		return $request->get('domain'). '/image/'.  $file;
    }

}


if (! function_exists('is_image')) {

    function is_image($url)
    {
        return preg_match("(^[http:\/\/|https:\/\/].*\.[svg|png|jpg|jpeg]*)", $url);
    }

}

if (! function_exists('translit')) {

    function translit($string) {
        $string = (string) $string;
        $string = strip_tags($string);
        $string = str_replace(array("\n", "\r"), " ", $string);
        $string = preg_replace("/\s+/", ' ', $string);
        $string = trim($string);
        $string = function_exists('mb_strtolower') ? mb_strtolower($string) : strtolower($string);
        $string = strtr($string, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        $string = preg_replace("/[^0-9a-z-_ ]/i", "", $string);
        $string = str_replace(" ", "-", $string);
        return $string;
    }

}

