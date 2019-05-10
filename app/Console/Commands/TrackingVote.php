<?php

namespace App\Console\Commands;

use App\Repositories\StoryRepository;
use Illuminate\Console\Command;

class TrackingVote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TrackingVote:tracking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tracking vote of story every minute';

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
    public function handle(StoryRepository $eloquent)
    {
        $eloquent->trackingByVote();
    }
}
