<?php
/**
 * A class that contains code to handle any requests for  /deletemodule/
 */
     namespace Pages;

     use \Support\Context as Context;
     use \Config\Config as Config;
/**
 * Support /deletemodule/
 */
    class Deletemodule extends \Framework\Siteaction
    {
/**
 * Handle deletemodule operations
 *
 * @param object	$context	The context object for the site
 *
 * @return string	A template name
 */
        public function handle(Context $context)
        {
            return '@content/deletemodule.twig';
        }
    }
?>