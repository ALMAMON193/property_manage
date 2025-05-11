<?php

namespace App\Console\Commands;

use App\Http\Controllers\Web\Backend\ProductController;
use App\Models\Retailer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateRetailers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:retailers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update retailer products based on their update_interval';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all retailers
        $retailers = Retailer::all();

        foreach ($retailers as $retailer) {
            // Skip updates for "never" intervals
            if ($retailer->update_interval === 'never') {
                continue;
            }

            // Check the update interval
            if ($retailer->update_interval === 'live' || $this->shouldUpdate($retailer)) {
                $controller = app(ProductController::class);
                $controller->update($retailer->id);
            }
        }

        $this->info('Retailers product updated successfully.');
    }

    private function shouldUpdate($retailer)
    {
        // Log the values for debugging

        // Get the most recently updated product for this retailer
        $latestProduct = $retailer->products()->latest('updated_at')->first();

        // Log product's last update time for debugging
        if ($latestProduct) {
            \Log::info("Last Product Updated At (DB): {$latestProduct->updated_at}");
        } else {
            \Log::info("No products found for retailer ID: {$retailer->id}");
        }

        // If there are no products, fallback to a long time ago
        $lastUpdated = $latestProduct ? $latestProduct->updated_at : Carbon::now()->subYears(1);

        // Get the current time in the same time zone as the database timestamp (if necessary)
        $now = Carbon::now(); // This will use the system's current time zone.

        // Make sure both times are in the same time zone (UTC or whatever time zone is appropriate)
        $lastUpdatedCarbon = Carbon::parse($lastUpdated)->setTimezone($now->getTimezone());

        // Log the times for comparison
        \Log::info("Current Time: {$now}");
        \Log::info("Last Updated Time: {$lastUpdatedCarbon}");

        // Ensure the interval is treated as an integer
        $intervalInMinutes = is_numeric($retailer->update_interval) ? (int) $retailer->update_interval : 0;

        // Log the minutes calculation
        $minutesSinceLastUpdate = $lastUpdatedCarbon->diffInMinutes($now);
        \Log::info("Minutes since last update: {$minutesSinceLastUpdate}");
        \Log::info("Interval in minutes: {$intervalInMinutes}");

        // Check if it's time to update
        return $minutesSinceLastUpdate >= $intervalInMinutes;
    }




}
