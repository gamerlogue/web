<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddViteToSailSupervisorCommand extends Command
{
    protected $signature = 'app:add-vite-to-sail-supervisor';

    protected $description = 'Add Vite DEV server to the Sail supervisor';

    public function handle(): void
    {
        $this->info('Adding Vite to the Sail supervisor...');

        $conf = '[program:vite]
command=bash -c "corepack enable && gosu %(ENV_WWWUSER)s bash -c \'cd /var/www/html && pnpm dev\'"
user=root
environment=LARAVEL_SAIL="1"
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0';

        // Add $conf to file if not already present
        $path = base_path('vendor/laravel/sail/runtimes/8.3/supervisord.conf');
        $contents = file_get_contents($path);
        if (! str_contains($contents, $conf)) {
            file_put_contents($path, "\n$conf", FILE_APPEND);
            $this->info('Vite has been added to the Sail supervisor.');
        } else {
            $this->info('Vite is already present in the Sail supervisor.');
        }
    }
}
