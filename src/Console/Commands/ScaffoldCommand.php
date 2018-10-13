<?php
/**
 * Contains the Appshell Scaffold Command class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-04-06
 *
 */


namespace Konekt\AppShell\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class ScaffoldCommand extends Command
{
    use DetectsApplicationNamespace;

    /** @var string The name and signature of the console command */
    protected $signature = 'appshell:scaffold
                    {--views : Only scaffold the authentication views}
                    {--force : Overwrite existing views by default}';

    /** @var string Command's description */
    protected $description = 'Scaffold appshell basic views and routes';

    protected function getStub()
    {
        // TODO: Implement getStub() method.
    }
}
