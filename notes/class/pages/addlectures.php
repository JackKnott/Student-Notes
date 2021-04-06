<?php
/**
 * A class that contains code to handle any requests for  /addlectures/
 */
     namespace Pages;

     use \Support\Context as Context;
     use \Config\Config as Config;
     use \R as R;
/**
 * Support /addlectures/
 */
    class AddLectures extends \Framework\Siteaction
    {
/**
 * Handle addlectures operations. Adds all modules to page. On form submission, get module code from dropdown, date and start time of lecture. Error check and return error if needed, otherwise add to database.
 *
 * @param object	$context	The context object for the site
 *
 * @return string	A template name
 */
        public function handle(Context $context)
        {
            $code = '';
            $date = '';
            $startTime = '';

            $modules = R::getAll("SELECT * FROM module");
            $context->local()->addval('modules', $modules);

            $fd = $context->formdata();
            if ($fd->haspost('date') && $fd->haspost('code') && $fd->haspost('time')) 
            {
                $code = $fd->post('code');
                $date = $fd->post('date');
                $startTime = $fd->post('time');
                if (!empty($code) && !empty($date) && !empty($startTime))
                {
                    if (preg_match("/([a-zA-Z]{3}[0-9]{4})/", $code))
                    {
                        preg_match("/([a-zA-Z]{3}[0-9]{4})/", $code, $match);
                        $code = $match[0];

                        if (preg_match("/([0-9]{4}(-)[0-9]{2}(-)[0-9]{2})/", $date))
                        {
                            preg_match("/([0-9]{4}(-)[0-9]{2}(-)[0-9]{2})/", $date, $match);
                            $date = $match[0];

                            if (preg_match("/([0-9]{2}(:)[0-9]{2})/", $startTime))
                            {
                                preg_match("/([0-9]{2}(:)[0-9]{2})/", $startTime, $match);
                                $startTime = $match[0];

                                $lecture = R::dispense('lecture');
                    
                                $lecture->date = $date;
                                $lecture->module_code = $code;
                                $lecture->start_time = $startTime;

                                $id = R::store($lecture);
                        
                            }
                        }
                    }
                }
                else
                {
                    $context->local()->message(\Framework\local::ERROR, "Please fill in the form");
                }
            }
            return '@content/addlectures.twig';
        }
    }
?>