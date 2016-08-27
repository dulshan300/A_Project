<?php

/**
 * CodeDlab
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package        CodeDlab
 * @author        CodeDlab Dev A.G.D.Madusanka
 * @copyright    Copyright (c) 2012 - 2013, DLab, Digital X Design.
 * @since        Version 1.0
 *
 */

class Welcome extends CD_Controller
{

    /**
     *
     */
    public function index()
    {
        $site = $GLOBALS['setting']['site'];

        echo $this->view->render("html/page2.php", [
            
            'name'        => $site['name'],
            'description' => $site['description'],
            'res_path'    => ASSETS_PATH,
            'css'         => CSS_PATH,
            'js'          => JS_PATH,
            'url_home'    => url(""),
            'url_site'    => url("site/"),
            'this_year'   => get_date("Y"),

        ]);


        $cust = new Customer();
        $cust = $cust->last();

        echo $cust->CustName.'<br>';

        echo "<pre>";

        foreach ($cust->getAll() as $c) {
            if ($c->isSalaryGT(60000)) {
               echo $c->CustName."\t ".$c->Salary.'<br>';
            }
            
        }

       

        echo "<br><br><br>";

        // $item = new Item();
        // foreach ($item->getAll() as $i) {
        //     foreach ($i->getColumns() as $value) {

        //         echo $i->$value."\t\t";
        //     }
        //     echo "<br>";
            
        // }
        //$cust->update();

        //Danapala
        

    }

}
