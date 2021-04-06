<?php
/**
 * A class that contains code to handle any requests for  /leaderboard/
 */
     namespace Pages;

     use \Support\Context as Context;
     use \Config\Config as Config;
     use \R as R;
/**
 * Support /leaderboard/
 */
    class Leaderboard extends \Framework\Siteaction
    {
/**
 * Handle leaderboard operations. Display all details about uploads. Order by downloads to display correct leaderboard.
 *
 * @param object	$context	The context object for the site
 *
 * @return string	A template name
 */
        public function handle(Context $context)
        {
            $details = R::getAll("SELECT DISTINCT uploaddetail.downloads, uploaddetail.id, upload.filename, uploaddetail.upload_id, uploaddetail.file_name, uploaddetail.file_description, upload.user_id, module.code as module_code, module.name as module_name, lecture.start_time as lecture_time, lecture.date as date FROM uploaddetail INNER JOIN lecture ON lecture.id = uploaddetail.lecture_id INNER JOIN module ON lecture.module_code = module.code INNER JOIN upload ON upload.id = uploaddetail.upload_id ORDER BY downloads DESC LIMIT 25");
            $context->local()->addval('details', $details);
            
            return '@content/leaderboard.twig';
        }
    }
?>