<?php

namespace App\Console\Commands;

use App\Repository\NewsRepository;
use DateTimeImmutable;
use Illuminate\Console\Command;

class DeleteOldNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:delete {days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old news';

    private NewsRepository $repository;

    /**
     * Create a new command instance.
     *
     * @param NewsRepository $repository
     */
    public function __construct(NewsRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $date = (new DateTimeImmutable('now'))->modify('-' . $this->argument('days') . ' days');

        $this->repository->deleteByDate($date);

        return 0;
    }
}
