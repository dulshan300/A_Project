<?php

/**
 * User: Dulshan M
 * Date: 4/17/2016
 *
 */
class Template
{
    private $data = array();
    private $content = null;

    function __construct($view, $data = array(), $error = true)
    {
        $file = 'application/view/' . $view;
        if (file_exists($file)) {
            $this->content = file_get_contents($file);
        } else
            ($error) ? trigger_error("File (<b>\"$file\"</b>) Not found") : "";

    }

    /**
     * This Function will add php data to template:
     * addData('name','appName'), in template {{name}} will appName
     * @param $key
     * @param $val
     */
    function addData($key, $val)
    {
        $this->data['{{' . $key . "}}"] = $val;
    }

    private function outputClean($arr)
    {
        $out = array();
        if (is_array($arr)) {
            foreach ($arr as $key) {
                $found = false;
                foreach ($out as $res) {
                    if ($key == $res) {
                        $found = true;
                    }
                }
                if (!$found)
                    $out[] = $key;
            }
        }
        return $out;
    }

    public function encode_Data()
    {
        $output_array = array();
        preg_match_all("/({{)((|[a-z]|[A-Z]|(-)|(_*))+)(-*)(_*)([0-9]*)(}})/", $this->content, $output_array, 1);
        $out_filted = $this->outputClean($output_array[0]);

        foreach ($out_filted as $key) {
            if (array_key_exists($key, $this->data)) {
                $this->content = str_replace($key, $this->data[$key], $this->content);
            } else
                trigger_error("Key (<b>\"$key\"</b>) Not Defined <br>");
        }
        return $this->content;
    }

    function render()
    {
        echo $this->encode_Data();
    }


} 