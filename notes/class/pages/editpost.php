<?php
/**
 * A class that contains code to handle any requests for  /editpost/
 */
     namespace Pages;

     use \Support\Context as Context;
     use \Config\Config as Config;
     use \R as R;

/**
 * Support /editpost/
 */
    class Editpost extends \Framework\Siteaction
    {
/**
 * Handle editpost operations. Get upload details and display as placeholders in form. If form submitted, take data and change information in database.
 *
 * @param object	$context	The context object for the site
 *
 * @return string	A template name
 */
        public function handle(Context $context)
        {
            $fd = $context->formdata();
            $uploadID = $fd->get('uploadID');
            $detailID = $fd->get('uploadDetailsID');

            $upload = R::getAll("SELECT * FROM uploaddetail WHERE upload_id='".$uploadID."'");
            $context->local()->addval('notes', $upload);

            $file = R::getAll("SELECT * FROM upload WHERE id='".$uploadID."'");
            $context->local()->addval('file', $file);

            $userID = $context->user()->getID();
            $context->local()->addval('userid', $userID);

            $oldfile = R::findOne('upload', 'id=?', [$fd->get('uploadID')]);

            if ($fd->haspost('filename')) 
            {
                $newfile = R::load('uploaddetail', $detailID);
                $newfile->file_name = $fd->post('filename');
                $newfile->file_description = $fd->post('description');
                $id = R::store($newfile);

                foreach(new \Framework\FAIterator('update') as $ix => $fa) 
                {
                    $filepath = R::load('upload', $uploadID);
                    $id = $filepath->replace($context, $fa);
                }
                
                // Refresh values in form
                $upload = R::getAll("SELECT * FROM uploaddetail WHERE upload_id='".$uploadID."'");
                $context->local()->addval('notes', $upload);
            }
            return '@content/editpost.twig';
        }
    }


?>