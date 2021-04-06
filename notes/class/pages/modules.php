<?php
/**
 * A class that contains code to handle any requests for  /modules/
 */
     namespace Pages;

     use \Support\Context as Context;
     use \Config\Config as Config;
     use \R as R;
/**
 * Support /modules/
 */
    class Modules extends \Framework\Siteaction
    {
/**
 * Handle modules operations. Displays all modules.
 *
 * @param object	$context	The context object for the site
 *
 * @return string	A template name
 */
        public function handle(Context $context)
        {
            $modules = R::getAll("SELECT * FROM module");
            $context->local()->addval('modules', $modules);
            return '@content/modules.twig';
        }
    }
?>