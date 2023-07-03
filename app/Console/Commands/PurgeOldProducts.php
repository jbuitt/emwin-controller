<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use Carbon\Carbon;

class PurgeOldProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emwin-controller:purge_old_products {days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge old product files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): int
    {
        $days = $this->argument('days');
        // Make sure input is valid
        if (!is_numeric($days) && $days > 0) {
            print "Error: Supplied number of days '$days' is invalid. Should be a number greater than 0.\n";
            return 1;
        }
        // Delete old products from database
        Log::info('Purging products older than ' . $days . ' days from database..');
        Product::whereDate('created_at', '<=', Carbon::now()->subDays($days))->delete();
        // Delete old products from filesystem
        Log::info('Purging EMWIN products older than ' . $days . ' days from filesystem..');
        exec('/usr/bin/find ' . storage_path(config('emwin-controller.emwin.archivedir')) . ' -mtime +' . $days . ' -delete 2>&1', $output, $exitCode);
        // Done!
        if ($exitCode !== 0) {
            print "Error: " . implode("\n", $output) . "\n";
        }
        print("Done.\n");
        return $exitCode;
    }
}
