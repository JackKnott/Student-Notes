<?php 
/**
 * A class that contains code to handle any requests for  /addmodule/
 */
     namespace Pages;

     use \Support\Context as Context;
     use \Config\Config as Config;
     use \R as R;
/**
 * Support /addmodule/
 */
    class Addmodule extends \Framework\Siteaction
    {
/**
 * Handle addmodule operations.  Adds all modules to page. On form submission, get module code and module name. Error check and return error if needed, otherwise add to database.
 *
 * @param object	$context	The context object for the site
 *
 * @return string	A template name
 */
        public function handle(Context $context)
        {
            $code = '';
            $name = '';

            $modules = R::getAll("SELECT * FROM module");
            $context->local()->addval('modules', $modules);
            
            $fd = $context->formdata();
            if ($fd->haspost('name') && $fd->haspost('code')) 
            {
                $name = $fd->post('name');
                $code = $fd->post('code');
                if (!empty($code) && !empty($name))
                {
                    if (preg_match("/([a-zA-Z]{3}[0-9]{4})/", $code))
                    {
                        preg_match("/([a-zA-Z]{3}[0-9]{4})/", $code, $match);
                        $code = $match[0];

                        $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);

                        $module = R::dispense('module');

                        $module->name = $name;
                        $module->code = $code;

                        $id = R::store($module);
                    }
                    else
                    {
                        $context->local()->message(\Framework\local::ERROR, "Module code not correct");
                    }
                }
                else
                {
                    $context->local()->message(\Framework\local::ERROR, "Please fill in the form");
                }
            }

            return '@content/addmodule.twig';
        }
    }
?>