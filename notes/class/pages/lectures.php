<?php
/**
 * A class that contains code to handle any requests for  /lectures/
 */
     namespace Pages;

     use \Support\Context as Context;
     use \Config\Config as Config;
     use \R as R;
/**
 * Support /lectures/
 */
    class Lectures extends \Framework\Siteaction
    {
/**
 * Handle lectures operations. Displays all lectures.
 *
 * @param object	$context	The context object for the site
 *
 * @return string	A template name
 */
        public function handle(Context $context)
        {
            $lectures = R::getAll("SELECT * FROM lecture");
            $context->local()->addval('lectures', $lectures);

            $modules = R::getAll("SELECT * FROM module");
            $context->local()->addval('modules', $modules);
            return '@content/lectures.twig';
        }
    }
?>