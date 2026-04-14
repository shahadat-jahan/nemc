<?php

namespace App\Console\Commands;

use App\Models\ClassRoutine;
use Illuminate\Console\Command;

class WardTypeClassMigration extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'migrate:ward-type-class';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Migrate ward type (14) classes to evening classes based on start time at or after 3:00 PM';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->comment('Starting ward type class migration...');

        $updatedCount = ClassRoutine::where('class_type_id', 14)
                                    ->whereTime('start_from', '>=', '15:00:00')
                                    ->update(['class_type_id' => 18]);

        $this->info('Total records updated from Ward Placement (14) to Evening class (18) for classes starting at or after 3:00 PM: ' . $updatedCount);
        $this->comment('Ward type class migration completed successfully.');
    }
}
