# Job Ads Checkout

Application for Job Ads checkout with custom pricing for different customers.

## Technical Overview
Backend APIs using:
 - Laravel 5.8 framework
 - Swagger for APIs documentation
 
Frontend:
 - AngularJS 1.7.8.
 - Bootstrap for UI
 - Karma & Jasmine for testing.
 - swagger-js to discover APIs from Backend API Server.

## Solution Overview
For this implementation, the frontend codes sits within the `public/` folder of the backend codes. However, it can be split out as there are no direct depedency between the frontend and backend codes. 
<br/><br/>
Backend API logic for the pricing are situated in `app/Http/Api/OrderController@calculateTotalPrice` function.
 Configuration for the pricing/discount for customers are store in database and can be configure for new customers by adding in new records. Currently SQLite is use for its portability, but it can be change to other RDBMS as it is abstracted via Laravel's Eloquent Model.
<br/><br/>
Frontend UI logic for the checkout page are situated in `public/app/components/order/oder.component.js`.
<br/><br/>
Tests are split to Backend API tests and Frontend tests. Backend test are done via Laravel in built test framework(PHPUnit) and the test cases are situated in `tests\Feature`. Frontend tests are done using Karma test runner and Jasmine test framework and the test cases are situated `public\tests\specs\`.

## Prerequisite
- PHP 7.3 (for running Backend API Server)<br />
  Extensions : BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, SQLite
- NodeJS and npm (for running frontend test)

## Starting the Development Server
`php artisan serve` <br/>

Job Ads Checkout Page : http://127.0.0.1:8000<br/>
Swagger UI : http://127.0.0.1:8000/api/documentation<br/>
Swagger API Docs : http://127.0.0.1:8000/docs/api-docs.json<br/>

## Running tests

APIs feature tests, run the command: `./vendor/bin/phpunit`

Frontend tests, run the command: `npm run test`