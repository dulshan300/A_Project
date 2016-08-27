<?php

class Generate {

    public static function into_patten($patten, $value, $side = 0) {

        if ($side == 0) {
            return $patten . $value;
        } else {
            return $value . $patten;
        }
    }

    public static function gen_next($patten, $string) {

        $str_len = strlen($string);
        $ptn_len = strlen($patten);
        $val = intval(substr($string, $ptn_len));
        $val+=1;
        $val_len = strlen("$val");
        $z = $str_len - ($ptn_len + $val_len);
        $zero = "";
        for ($i = 0; $i < $z; $i++) {
            $zero.="0";
        }

        return $patten . $zero . $val;
    }

    public static function gen_custom_sha($text, $start, $last) {
        $string = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $span = substr(str_shuffle($string), 0, $last);
        $prespan = substr(str_shuffle($string), 0, $start);
        $samp = self::gen_sample(sha1($text));
        return $prespan . $samp . $span;
    }

    public static function gen_sample($text, $seed = null) {
        if ($seed == null) {
            //$seeds = array(11,19,36,8,17,34,32,7,0,6,38,30,3,24,9,35,10,1,25,39,31,18,26,33,13,22,16,20,5,15,12,23,27,2,4,28,37,21,29,44,48,42,46,47,43,41,40,49,45);
            $seeds = array(11, 19, 36, 8, 17, 34, 14, 32, 7, 0, 6, 38, 30, 3, 24, 9, 35, 10, 1, 25, 39, 31, 18, 26, 33, 13, 22, 16, 20, 5, 15, 12, 23, 27, 2, 4, 28, 37, 21, 29);
        }
        $sampled = "";
        foreach ($seeds as $ind) {
            $sampled.=$text[$ind];
        }
        return $sampled;
    }

    public static function gen_substr($text, $left, $right = 0) {
        $len = strlen($text);
        $fix_tot = $len - $right - $left;
        $st = $len - $fix_tot;
        $s = substr($text, $left, $fix_tot);

        return $s;
    }

}

?>