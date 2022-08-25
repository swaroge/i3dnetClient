<?php

namespace App\Console\Commands;

use App\Exceptions\I3dnetClientException;
use App\Models\Account;
use App\Services\I3dnetClientService;
use Illuminate\Console\Command;

class FetchApiLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-logs {apiKey} {--type=} {--start=0} {--results=10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch API Logs for the account';

    /**
     * @var I3dnetClientService
     */
    protected $client;

    /**
     * Create a new command instance.
     *
     * @param I3dnetClientService $client
     */
    public function __construct(I3dnetClientService $client)
    {
        $this->client = $client;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $apiKey = $this->argument('apiKey');
            $type = $this->option('type')?? null;
            $start = intval($this->option('start'));
            $results = intval($this->option('results'));

            $user = $this->client->getUser($apiKey);
            $this->info('Fetching API logs for account ' . $user['userName'] .'.');

            $logs = $this->client->getAccountApiLog($apiKey, $start, $results,  $type);
            $this->info(count($logs) . ' of API logs fetched.');

            $account = Account::where('userId','=', $user['userId'])->first();
            if(!$account) {
                $this->warn('Account for ' . $user['userName'] . ' is not existed. Creating account');
                $account = $this->client->storeUserAndDetails($user);
                $this->info('Account for ' . $account->userName . ' successfully created');
            }

            $updated = $this->client->processLogs($account, $logs);

            $this->info($updated . ' of new API log records saved.');

        } catch (I3dnetClientException $e) {
            $this->error($e->getMessage());
        }
        return 0;
    }
}
