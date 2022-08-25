<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Services\I3dnetClientService;
use Illuminate\Console\Command;

class FetchAccountDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-details {apiKey}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Account Details';

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
            $action = 'saved';
            $apiKey = $this->argument('apiKey');
            $this->info('Fetching account details for API key '.$apiKey);

            $user = $this->client->getUser($apiKey);
            $details = $user['details'];
            unset($user['details'], $user['billingDetails']);

            $account = Account::where('userId','=', $user['userId'])->first();
            if ($account) {
                $account->update($user);
                $account->details()->update($details);
                $action = 'updated';
            } else {
                $this->client->storeUserAndDetails($user, $details);
            }

            $this->info('Account details ' . $action );
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        return 0;
    }
}
