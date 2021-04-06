<?php
/**
 * A class that contains code to handle any requests for  /viewdocument/
 */
     namespace Pages;

     use \Support\Context as Context;
     use \Config\Config as Config;
     use \R as R;
/**
 * Support /viewdocument/
 */
    class Viewdocument extends \Framework\Siteaction
    {
/**
 * Handle viewdocument operations
 *
 * @param object	$context	The context object for the site
 *
 * @return string	A template name
 */
        public function handle(Context $context)
        {
            $fd = $context->formdata();
            $uploadID = $fd->get('uploadid');

            $details = R::getAll("SELECT DISTINCT uploaddetail.downloads, uploaddetail.id, upload.filename, uploaddetail.upload_id, uploaddetail.file_name, uploaddetail.file_description, upload.user_id, module.code as module_code, module.name as module_name, lecture.start_time as lecture_time, lecture.date as date FROM uploaddetail INNER JOIN lecture ON lecture.id = uploaddetail.lecture_id INNER JOIN module ON lecture.module_code = module.code INNER JOIN upload ON upload.id = uploaddetail.upload_id WHERE upload.id = '" . $uploadID . "'");
            $context->local()->addval('details', $details);

            if ($fd->haspost('documentid'))
            {
                // Increment download counter
                $document = R::findOne('uploaddetail', 'upload_id=?', [$fd->post('documentid')]);
                $document->downloads = $document->downloads + 1;
                $update = R::store($document);

                // Find file
                $file = R::findOne('upload', 'id=?', [$fd->post('documentid')]);

                if ($file->canaccess($context->user())) 
                {
                    // Download file
                    $this->file = substr($file->fname, 1);
                    $context->web()->sendfile($this->file,$file->fname);
                }
            }

            return '@content/viewdocument.twig';
        }
    }
?>