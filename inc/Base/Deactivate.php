<?php

/*
*
* @package yariko
*
*/

namespace Mlp\Inc\Base;

class Deactivate{

    public static function deactivate(){
        flush_rewrite_rules();
    }
}
