<?php

namespace LaravelPeru\Ubigeo\Console\Commands;

use Illuminate\Console\Command;
use LaravelPeru\Ubigeo\LaravelPeruUbigeoServiceProvider;

class PublishUbigeoResourcesCommand extends Command
{
    protected $signature = 'ubigeo:publish
                            {--model : Publish App\\Models\\Ubigeo.php}
                            {--migration : Publish ubigeo migration}
                            {--force : Overwrite existing files}';

    protected $description = 'Publish ubigeo model and migration from the package';

    public function handle(): int
    {
        $publishAll = !$this->option('model') && !$this->option('migration');

        $tags = [];

        if ($publishAll || $this->option('model')) {
            $tags[] = 'ubigeo-model';
        }

        if ($publishAll || $this->option('migration')) {
            $tags[] = 'ubigeo-migrations';
        }

        foreach ($tags as $tag) {
            $parameters = [
                '--provider' => LaravelPeruUbigeoServiceProvider::class,
                '--tag' => $tag,
            ];

            if ($this->option('force')) {
                $parameters['--force'] = true;
            }

            $this->call('vendor:publish', $parameters);
        }

        $this->info('Ubigeo resources published.');

        return self::SUCCESS;
    }
}
