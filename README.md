## I3Dnet Client Assessment

**Assessment used  Laravel v.9 and PHP 7.4**

### Installation 
- `composer install`
- `cp .env.example  .env` and config the DB credos (create schema ofcourse)
- `php artisan migrate`
- `php artisan db:seed`

### Commands
- `php artisan app:fetch-details {apiKey}`
- `php artisan app:fetch-logs {apiKey} --start=int|0 --results=int|10 --type=null|get|post|put|patch|delete`

### Model/Tables

- `user` - default table for the auth in laravel package. Do not used in this assessment.
- `account` - store the user info from i3d.net https://www.i3d.net/docs/api/v3/all#/Session/getUser
- `details` - store account details from i3d.net https://www.i3d.net/docs/api/v3/all#/AccountDetails/getAccountDetails
- `apilog` - store account Api logs from i3d.net https://www.i3d.net/docs/api/v3/all#/APILog/getAccountApiLogs
