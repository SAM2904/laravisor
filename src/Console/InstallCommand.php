<?php

namespace Sam\Laravisor\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'laravisor:install';

    /**
     * The console command description.
     */
    protected $description = 'Install Laravisor configuration only';

    public function handle(): int
    {
        $this->callSilent('vendor:publish', ['--tag' => 'laravisor-config']);

        $this->info('Laravisor config published.');
        $this->line('No migrations or storage changes are required.');

        return self::SUCCESS;
    }
}
