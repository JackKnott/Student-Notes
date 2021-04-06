<?php
/**
 * A class that contains code to handle any requests for  /mynotes/
 */
     namespace Pages;

     use \Support\Context as Context;
     use \Config\Config as Config;
/**
 * Support /mynotes/
 */
    class Mynotes extends \Framework\Siteaction
    {
/**
 * Handle mynotes operations
 *
 * @param object	$context	The context object for the site
 *
 * @return string	A template name
 */
        public function handle(Context $context)
        {
            return '@content/mynotes.twig';
        }
    }
?>