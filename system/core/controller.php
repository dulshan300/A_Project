<?php

/**
 * CodeDlab
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeDlab
 * @author		CodeDlab Dev A.G.D.Madusanka.
 * @copyright	Copyright (c) 2012 - 2013, DLab, Digital X Design.
 * @since		Version 1.0
 * 
 */

abstract class CD_Controller  extends Service {
    
    
        //Man Method
    abstract public function index();

    /**
     * Load the view with data array ...
     * @param file $view
     * @param array $data
     */
    protected function load_view($view, $data) {
        if (is_array($data)) {
            extract($data);
            $file = 'application/view/' . $view;
            if (file_exists($file)) {
                include_once $file;
            } else {
                trigger_error("File (<b>\"$file\"</b>) Not found");
            }
        } else {
            trigger_error("data must be in a array");
        }
    }

    public function authorize() {
        // check the global session variable to check the autho status
        // else redirect to login page
        if(!$_SESSION['login_status'])
            redirect_to('site/');
    }



}

?>