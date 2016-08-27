<?php

/**
 * CodeDlab
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeDlab/Helpers
 * @author		CodeDlab Dev A.G.D.Madusanka
 * @copyright	Copyright (c) 2012 - 2013, DLab, Digital X Design.
 * @since		Version 1.0
 * 
 */
function redirect_to($loc) {
    if ($loc) {
        header("Location:" . BASE_PATH . "/" . $loc);
    }
}

function error_page($meg = "") {
    echo '<h1>' . $meg . '</h1>';
}

function css($file) {
    return CSS_PATH . "$file";
}

function js($file) {
    return JS_PATH . "$file";
}

function url($path) {
    return BASE_PATH . "/$path";
}

function get_date($format = null) {
    $d = new DateTime();
    if ($format == null) {
        return $d->format("Y-m-d");
    } else {
        return $d->format($format);
    }
}

function format_date($date, $format = null) {
    $d = new DateTime($date);
    if ($format == null) {
        return $d->format("Y-m-d");
    } else {
        return $d->format($format);
    }
}

// HTML Tag 

/**
 * 
 * @param String $action
 * @param String $method
 * @param String $name
 * @param arrya $option
 * @return String
 */
function form_open($action, $method, $name = "", $option = null) {
    $name = (empty($name)) ? "" : 'name="' . $name . '" ';
    $opt = __option_extract($option);
    return '<form ' . $opt . $name . 'action="' . $action . '" method="' . $method . '">' . "\n";
}

/**
 * 
 * @return String
 */
function form_close() {
    return '</form>' . "\n";
}

/**
 * 
 * @param String $text
 * @param String $url
 * @param String $target
 * @param array $option
 * @return String
 */
function Tag_a($text, $url, $target = "", $option = null) {
    $target = (empty($target)) ? "" : ' target="' . $target . '"';
    $opt = __option_extract($option);
    return '<a ' . $opt . 'href="' . $url . '"' . $target . '>' . Html_scape($text) . '</a>' . "\n";
}

/**
 * 
 * @param String $src
 * @param String $alt
 * @param array $option
 * @return String
 */
function Tag_img($src, $alt = "", $option = null) {
    $alt = (!empty($alt)) ? ' alt="' . Html_scape($alt) . '" ' : "";
    $opt = __option_extract($option);
    return '<img src="' . $src . '"' . $alt . $opt . '>' . "\n";
}

/**
 * 
 * @param String $text
 * @param array $option
 * @return String
 */
function Tag_p($text, $option = null) {
    $opt = __option_extract($option);
    return '<p ' . $opt . '>' . Html_scape($text) . '</p>' . "\n";
}

/**
 * 
 * @param array $data
 * @param String $select
 * @param String $option
 */
function Tag_select($data, $select = "", $option = null) {
    $opt = __option_extract($option);
    $out = "";
    $sel = "";
    if (is_array($data)) {
        $out.='<select ' . $opt . '>' . "\n";
        foreach ($data as $val => $text) {
            if (!empty($select)) {
                if ($val == $select) {
                    $sel = " selected ";
                }
            }
            $out.='<option value="' . $val . '"' . $sel . '>' . Html_scape($text) . '</option>' . "\n";
        }
        $out.='</select>' . "\n";
    }
    return $out;
}

function Tag_text($name, $value = "", $option = null) {
    $opt = __option_extract($option);
    return '<input ' . $opt . ' type="text" name="' . Html_scape($name) . '" ' . ((!empty($value)) ? 'value="' . Html_scape($value) . '"' : "") . '/>' . "\n";
}

function Tag_Button($text, $type = "Submit", $option = null) {
    $opt = __option_extract($option);
    return '<button ' . $opt . ' type="' . $type . '">' . Html_scape($text) . '</button>' . "\n";
}

function __option_extract($option) {
    $opt = "";
    if ($option != null) {
        if (is_array($option)) {
            foreach ($option as $key => $value) {
                $opt.= $key . '=' . '"' . $value . '" ';
            }
        }
    }
    return $opt;
}

function Html_scape($data) {
    return htmlspecialchars($data);
}