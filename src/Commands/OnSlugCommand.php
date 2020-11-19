<?php

namespace Konnco\OnSlug\Commands;

use Illuminate\Console\Command;

class OnSlugCommand extends Command
{
    public $signature = 'laravel-onslug';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
