<?php
    namespace Config;
/**
 * Generated by framework installer - Mon, 09 Jul 2018 13:50:57 +0100
*/
    class Config
    {
        const BASEDNAME	= '/xxx';
        const SESSIONNAME	= 'PSIxx';
        const PUTORPATCH    = 'PATCH';
        const DBTYPE	= 'mysql';
        const DBHOST	= 'xx';
        const DB	= 'xx';
        const DBUSER	= 'xxx';
        const DBPW	= 'xxx';
        const SITENAME	= 'xxx';
        const SITENOREPLY	= 'noreply@y.z';
        const SYSADMIN	= 'x@y.z';
        const DBRX	= FALSE;
        const REGISTER  = FALSE;
        const UPUBLIC	= FALSE;
        const UPRIVATE	= FALSE;
        const USEPHPM	= FALSE;
        const SMTPHOST = 'xxx';
        const FWCONTEXT = 'Site';
        const TESTCONTEXT = 'Test';
        const ADMINROLE = 'Admin';
        const DEVELROLE = 'Developer';
        const TESTROLE = 'Tester';
        const CONFIG = 'fwconfig';

        public static function setup() : void
        {
            \Framework\Web\Web::getinstance()->addheader([
                'Date'              => gmstrftime('%b %d %Y %H:%M:%S', time()),
                'Window-target'     => '_top',      # deframes things
                'X-Frame-Options'	=> 'DENY',      # deframes things
                'Content-Language'	=> 'en',
                'Vary'              => 'Accept-Encoding',
                'X-Clacks-Overhead' => 'GNU Terry Pratchett',
                'X-Content-Type-Options' => 'nosniff',
                'X-XSS-Protection'       => '1; mode=block',
                'Strict-Transport-Security' => 'max-age=31536000',
            ]);
        }
/** @var array */
        public static $defaultCSP = [
                'default-src' => ["'self'"],
                'font-src' => ["'self'", '*.fontawesome.com'],
                'img-src' => ["'self'", "data:", "*.amuniversal.com"],
                'script-src' => ["'self'", "stackpath.bootstrapcdn.com", "cdnjs.cloudflare.com", "code.jquery.com"],
                'style-src' => ["'self'", "*.fontawesome.com", "stackpath.bootstrapcdn.com"],
        ];
    }
?>