<?php
/**
 * A class that contains code to handle any requests for  /notes/
 */
     namespace Pages;

     use \Support\Context as Context;
     use \Config\Config as Config;
/**
 * Support /notes/
 */
    class Notes extends \Framework\Siteaction
    {
/**
 * Handle notes operations
 *
 * @param object	$context	The context object for the site
 *
 * @return string	A template name
 */
        public function handle(Context $context)
        {
            return '@content/notes.twig';
        }
    }
?>