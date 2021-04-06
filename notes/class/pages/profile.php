<?php
/**
 * A class that contains code to handle any requests for  /profile/
 */
     namespace Pages;

     use \Support\Context as Context;
     use \Config\Config as Config;
/**
 * Support /profile/
 */
    class Profile extends \Framework\Siteaction
    {
/**
 * Handle profile operations
 *
 * @param object	$context	The context object for the site
 *
 * @return string	A template name
 */
        public function handle(Context $context)
        {
            return '@content/profile.twig';
        }
    }
?>