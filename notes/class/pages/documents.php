<?php
/**
 * A class that contains code to handle any requests for  /documents/
 */
     namespace Pages;

     use \Support\Context as Context;
     use \Config\Config as Config;
     use \R as R;
/**
 * Support /documents/
 */
    class Documents extends \Framework\Siteaction
    {
/**
 * Handle documents operations. Displays documents on page. If module selected, lectures are able to be selected and documents in this module shown. If lecture selected, documents in that lecture selected. Admin can download and delete documents. Users can edit their own documents.
 *
 * @param object	$context	The context object for the site
 *
 * @return string	A template name
 */
        public function handle(Context $context)
        {
            // Get current user
            $userID = $context->user()->getID();
            $context->local()->addval('userid', $userID);

            $test = R::getAll("SELECT DISTINCT uploaddetail.id, upload.filename, uploaddetail.upload_id, uploaddetail.file_name, uploaddetail.file_description, upload.user_id, module.code as module_code, module.name as module_name, lecture.start_time as lecture_time, lecture.date as date FROM uploaddetail INNER JOIN lecture ON lecture.id = uploaddetail.lecture_id INNER JOIN module ON lecture.module_code = module.code INNER JOIN upload ON upload.id = uploaddetail.upload_id");
            $context->local()->addval('uploads', $test);

            $modules = R::getAll("SELECT * FROM module");
            $context->local()->addval('modules', $modules);

            $lectures = R::getAll("SELECT * FROM lecture");
            $context->local()->addval('lectures', $lectures);

            $fd = $context->formdata();

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

            if ($fd->haspost('module'))
            {
                $moduleCode = $fd->post('moduleCode');

                $lecturesMod = R::getAll('SELECT * FROM lecture WHERE module_code="'.$moduleCode.'"');
                $context->local()->addval('lectureSelect', $lecturesMod);

                $details = R::getAll("SELECT DISTINCT uploaddetail.id, upload.filename, uploaddetail.upload_id, uploaddetail.file_name, uploaddetail.file_description, upload.user_id, module.code as module_code, module.name as module_name, lecture.start_time as lecture_time, lecture.date as date FROM uploaddetail INNER JOIN lecture ON lecture.id = uploaddetail.lecture_id INNER JOIN module ON lecture.module_code = module.code INNER JOIN upload ON upload.id = uploaddetail.upload_id WHERE lecture.module_code ='" . $moduleCode . "'");
                $context->local()->addval('uploads', $details);
            }

            if ($fd->haspost('lecture'))
            {
                $lectureId = $fd->post('lectureId');

                $details = R::getAll("SELECT DISTINCT uploaddetail.id, upload.filename, uploaddetail.upload_id, uploaddetail.file_name, uploaddetail.file_description, upload.user_id, module.code as module_code, module.name as module_name, lecture.start_time as lecture_time, lecture.date as date FROM uploaddetail INNER JOIN lecture ON lecture.id = uploaddetail.lecture_id INNER JOIN module ON lecture.module_code = module.code INNER JOIN upload ON upload.id = uploaddetail.upload_id WHERE lecture.id = '" . $lectureId . "'");
                $context->local()->addval('uploads', $details);
            }

            if ($fd->haspost('deleteb'))
            {
                // Delete note
                $delete = R::exec("DELETE FROM uploaddetail WHERE upload_id='".$fd->post('deleteb')."'");
                $delete1 = R::exec("DELETE FROM upload WHERE id='" . $fd->post('deleteb') . "'");
            }

            return '@content/documents.twig';
        }
    }
?>