<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class service extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Создание файла Service.php
        $filename = app_path('Service.php');
        File::put($filename, '<?php' . PHP_EOL . PHP_EOL . 'class Service {' . PHP_EOL . PHP_EOL . '}');

        // Вывод сообщения об успешном создании файла
        $this->info('File Service.php created successfully.');
    }
}
