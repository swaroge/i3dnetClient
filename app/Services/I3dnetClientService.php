<?php
namespace App\Services;

use App\Contracts\Services\I3dnetClientServiceInterface;
use App\Exceptions\I3dnetClientException;
use App\Models\Account;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class I3dnetClientService extends ClientService implements I3dnetClientServiceInterface
{
    /**
     * Main Endpoint URL for API
     */
    const API_ENDPOINT = 'https://api.i3d.net/v3';

    /**
     * Endpoint urls
     */
    const ENDPOINTS = [
        'accountApiLog' => self::API_ENDPOINT . '/account/apiLog',
        'sessionUser' => self::API_ENDPOINT . '/session/user',
        'accountDetails' => self::API_ENDPOINT . '/account/details',
    ];

    /**
     * I3dnetClientService constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $apiKey
     * @return array
     * @throws I3dnetClientException
     */
    public function getUser(string $apiKey)
    {
        $responseData = $this->request($apiKey, self::ENDPOINTS['sessionUser']);

        return $this->processResponse($responseData);
    }

    /**
     * @param string $apiKey
     * @return array
     * @throws I3dnetClientException
     */
    public function getAccountDetails(string $apiKey)
    {
        $responseData = $this->request($apiKey, self::ENDPOINTS['accountDetails']);

        return $this->processResponse($responseData);
    }

    /**
     * @param string $apiKey
     * @param int $start
     * @param int $results
     * @param string|null $type
     * @return array
     * @throws I3dnetClientException
     */
    public function getAccountApiLog(string $apiKey, int $start = 0, int $results = 10, string $type = null)
    {
        $headers = [
            'RANGED-DATA' => 'start=' . $start . ',results=' . $results
        ];

        if ($type) {
            $responseData = $this->request($apiKey, self::ENDPOINTS['accountApiLog'] . '/' . $type, $headers);
        } else {
            $responseData = $this->request($apiKey, self::ENDPOINTS['accountApiLog'], $headers);
        }

        return $this->processResponse($responseData);
    }

    /**
     * @param array $user
     * @param null $details
     * @return mixed
     */
    public function storeUserAndDetails(array $user, $details = null)
    {
        if(!$details) {
            $details = $user['details'];
            unset($user['details'], $user['billingDetails']);
        }

        $account = Account::create($user);
        $account->details()->create($details);

        return $account;
    }

    /**
     * @param Account $account
     * @param array $logs
     * @return int
     */
    public function processLogs(Account $account, array $logs)
    {
        if($account->apilogs()->count()) {
            $processedLogs = collect($logs)->filter(function($item, $key) use ($account) {
                $string = $item['request']['url']
                    . $item['request']['method']
                    . $item['request']['ipAddress']
                    . $item['request']['requestTimestamp'];
                $res = DB::select(DB::raw("SELECT * FROM apilog WHERE md5_hash = md5('$string')"));

                return count($res) == 0;
            })->map(function($item, $key) use ($account) {

                return $this->prepareApiLogItem($item, $account->id);
            })->toArray();
        } else {
            $processedLogs = collect($logs)->map(function($item, $key) use ($account) {

                return $this->prepareApiLogItem($item, $account->id);
            })->toArray();
        }

        $account->apilogs()->insert($processedLogs);

        return count($processedLogs);
    }

    /**
     * @param array $item
     * @param int $account_id
     * @return array
     */
    protected function prepareApiLogItem(array $item, int $account_id)
    {
        $item['account_id'] = $account_id;
        $item['md5_hash'] = md5($item['request']['url']
            . $item['request']['method']
            . $item['request']['ipAddress']
            . $item['request']['requestTimestamp']);
        $item['request'] = json_encode($item['request']);
        $item['response'] = json_encode($item['response']);

        return $item;
    }

    /**
     * @param array $responseData
     * @return array
     * @throws I3dnetClientException
     */
    protected function processResponse(array $responseData)
    {
        if (Arr::exists($responseData, 'errorCode')) {
            throw new I3dnetClientException($responseData);
        }

        return $responseData;
    }


}
