<?php


namespace App\Contracts\Services;


use App\Exceptions\I3dnetClientException;
use App\Models\Account;

interface I3dnetClientServiceInterface
{

    /**
     * @param string $apiKey
     * @return array
     * @throws I3dnetClientException
     */
    public function getUser(string $apiKey);

    /**
     * @param string $apiKey
     * @return array
     * @throws I3dnetClientException
     */
    public function getAccountDetails(string $apiKey);

    /**
     * @param string $apiKey
     * @param int $start
     * @param int $results
     * @param string|null $type
     * @return array
     * @throws I3dnetClientException
     */
    public function getAccountApiLog(string $apiKey, int $start = 0, int $results = 10, string $type = null);

    /**
     * @param array $user
     * @param null $details
     * @return mixed
     */
    public function storeUserAndDetails(array $user, $details = null);

    /**
     * @param Account $account
     * @param array $logs
     * @return int
     */
    public function processLogs(Account $account, array $logs);
}
