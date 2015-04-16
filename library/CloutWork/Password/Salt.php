<?php

/**
 * Description of Salt
 *
 * @author rnest
 */
class CloutWork_Password_Salt
{

    public static function createSalt()
    {
        return md5(time());
    }

}
