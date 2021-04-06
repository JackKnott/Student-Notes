<?php
    namespace Config;
/**
 * Generated by framework installer - Mon, 07 Oct 2019 18:16:54 +0200
*/
    class Config
    {
        const BASEDNAME	= '/notes';
        const PUTORPATCH	= 'PATCH';
        const SESSIONNAME	= 'PSInotes';
        const DBTYPE	= 'mysql';
        const DBHOST	= 'localhost';
        const DB	= 'notes';
        const DBUSER	= 'notes';
        const DBPW	= 'csc3123';
        const SITENAME	= 'notes';
        const SITENOREPLY	= 'noreply@notes.org';
        const SYSADMIN	= 'jack.knott@newcastle.ac.uk';
        const DBRX	= FALSE;
        const REGISTER	= TRUE;
        const UPUBLIC	= FALSE;
        const UPRIVATE	= TRUE;
        const USECSP	= TRUE;
        const REPORTCSP	= TRUE;
        const USEPHPM	= FALSE;

        public static function setup()
        {
            \Framework\Web\Web::getinstance()->addheader([
            'Date'                   => gmstrftime('%b %d %Y %H:%M:%S', time()),
            'Window-Target'          => '_top',      # deframes things
            'X-Frame-Options'	     => 'DENY',      # deframes things: SAMEORIGIN would allow this site to use frames
            'Content-Language'	     => 'en',
            'Vary'                   => 'Accept-Encoding',
            'X-Content-Type-Options' => 'nosniff',
            'X-XSS-Protection'       => '1; mode=block',
            ]);
        }


        public static $defaultCSP = [
                'default-src' => ["'self'"],
                'font-src' => ["'self'", "data:", "*.fontawesome.com"],
                'img-src' => ["'self'", "data:"],
                'script-src' => ["'self'", "stackpath.bootstrapcdn.com", "cdnjs.cloudflare.com", "code.jquery.com"],
                'style-src' => ["'self'", "*.fontawesome.com", "stackpath.bootstrapcdn.com"],
        ];
    }

?>