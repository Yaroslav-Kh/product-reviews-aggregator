<?php

namespace Engine\Libraries;

use Engine\Core\Request;

class UrlManager {

    
    public static function makeUrl($path = null) {

        $request = new Request();

        return $request->get('domain') . $path;
    }

}