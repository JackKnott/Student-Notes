<?php
/**
 * A class that contains code to handle any requests for  /uploadnote/
 */
     namespace Pages;

     use \Support\Context as Context;
     use \Config\Config as Config;
     use \R as R;
/**
 * Support /uploadnote/
 */
    class Uploadnote extends \Framework\Siteaction
    {
/**
 * Handle uploadnote operations. Error checks and submits note to database.
 *
 * @param object	$context	The context object for the site
 *
 * @return string	A template name
 */
        public function handle(Context $context)
        {
            $modules = R::getAll("SELECT * FROM module");
            $context->local()->addval('modules', $modules);

            $fd = $context->formdata();

            $moduleCode = '';
            $name = '';
            $desc = '';

            if ($fd->haspost('moduleCode'))
            {
                $moduleCode = $fd->post('moduleCode');
                $moduleCode = filter_var($moduleCode, FILTER_SANITIZE_SPECIAL_CHARS);
                
                // Return lectures for module selected
                $lecturesMod = R::getAll('SELECT * FROM lecture WHERE module_code="'.$moduleCode.'"');
                $context->local()->addval('lectures', $lecturesMod);
            }

            if ($fd->haspost('lectureId'))
            {
                $lectureID = $fd->post('lectureId');
                $context->local()->addval('lecture', $lectureID);
            }

            if ($fd->hasfile('uploads'))
            {
                $name = $fd->post('name');
                $desc = $fd->post('desc');
                $lectureID = $fd->post('lecture');

                $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
                $desc = filter_var($desc, FILTER_SANITIZE_SPECIAL_CHARS);

                if (Config::UPUBLIC && Config::UPRIVATE)
                { # need to check the flag could be either private or public
                   foreach ($fd->posta('public') as $ix => $public)
                    {
                        $upl = R::dispense('upload');
                        $upl->savefile($context, $fd->filedata('uploads', $ix), $public, $context->user(), $ix);

                        $detail = R::dispense('uploaddetail');

                        $detail->file_name = $name;
                        $detail->file_description = $desc;
                        $detail->lecture_id = $lectureID;
                        $detail->upload_id = R::getCell('SELECT id FROM upload ORDER BY id DESC LIMIT 1');
                        $detail->downloads = 0;

                        $id = R::store($detail);
                    }
                }
                else
                {
                    foreach(new \Framework\FAIterator('uploads') as $ix => $fa)
                    { # we only support private or public in this case so there is no flag
                        $upl = R::dispense('upload');
                        $upl->savefile($context, $fa, Config::UPUBLIC, $context->user(), $ix);

                        $detail = R::dispense('uploaddetail');

                        $detail->file_name = $name;
                        $detail->file_description = $desc;
                        $detail->lecture_id = $lectureID;
                        $detail->upload_id = R::getCell('SELECT id FROM upload ORDER BY id DESC LIMIT 1');
                        $detail->downloads = 0;

                        $id = R::store($detail);
                    }
                }
            }
            return '@content/uploadnote.twig';
        }
    }
?>