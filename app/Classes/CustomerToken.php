<?php


namespace App\Classes;

 
define("BASE_URL", "https://offlineapp.caino.africa/api");

define("GENERATE_URL", "https://offlineapp.caino.africa/api/generate");

define('CREDENTIALS', (object)([
    'email' => env('TOKEN_API_USERNAME'),
    'password' => env('TOKEN_API_PASSWORD')
]));


class CustomerToken{

/*
*
* Gets token for customer-account from an external API/service
*/

private ?string $resToken = null; //6|1JXI3U43gsZBasg117bjhgVZRjE069TSsfQd9ruD

//asynchronus?
    
// $promise = Http::async()->get('http://localhost')->then(function ($response) {
//     echo "Response received!";
//     echo $response->body();
// });

    public function __construct(){

        $loginData = [
            'email' => CREDENTIALS->email,
            'password' => CREDENTIALS->password
        ];

        // Perform login and obtain access token
        $this->resToken = $this->login($loginData);

    }

    private function login($data) {
        $url = BASE_URL . '/login';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        if(!$result) {
            die("Login Failure");
        }

        curl_close($curl);

        // Extract and return the access token from the login response
        $responseData = json_decode($result);
        return $responseData->token;
    }


    public function callAPI(string $method, $data){ // $acessToken $url, 

        $curl = curl_init();

        switch ($method){
            case "POST": curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;

            case "PUT": curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
            default:

            if ($data)
                $url = sprintf("%s?%s", GENERATE_URL, http_build_query($data));
        }

        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.$this->resToken,
            'Content-Type: application/json',
        ));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // EXECUTE:
        $result = curl_exec($curl);

        if(!$result){die("Connection Failure");}
            curl_close($curl);
        return $result;

    }
    

    public function logout() {
        $url = BASE_URL . '/logout';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.$this->resToken,
            'Content-Type: application/json',
        ));

        $result = curl_exec($curl);

        if(!$result) {
            die("Logout Failure");
        }

        curl_close($curl);

        // Optionally, you may want to reset the stored token in your class
        $this->resToken = null;

        // Return any additional response data from the logout endpoint
        return json_decode($result);
    }

}