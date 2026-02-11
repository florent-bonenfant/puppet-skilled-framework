<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \App\Model\Sessions;

class CleanSessions extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        // Remove old user sessions
        Sessions::OldSessions()->delete();
    }
}
