<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SpellCheckRequest;
use App\Http\Requests\GetTokenRequest;
use App\Http\Requests\GetDifferencesRequest;


class ApiController extends Controller
{    
    /**
     * getToken
     *
     * @param  mixed $request
     * @return void
     */
    public function getToken(GetTokenRequest $request)
    {   
        $fields = [
            'PHP_AUTH_USER' => 'required',
            'PHP_AUTH_PW' => 'required',
        ];

        $validator = Validator::make($request->server->all(), $fields, [
            'PHP_AUTH_USER.required'   => 'Username required',
            'PHP_AUTH_PW.required'   => 'Password required.',
        ]);

        if ($validator->fails()) {
            $error_message = $this->getAPIErrors($validator, $fields);

            $this->response['status'] = false;
            $this->response['code'] = 400;
            $this->response['errors'] = $error_message;

            return $this->response;
        } 

        //PHP_AUTH_PW
        $auth_user = $request->server->get('PHP_AUTH_USER');
        $auth_password = $request->server->get('PHP_AUTH_PW');
        
        //do authentication
        
        $this->response['status'] = true;
        $this->response['code'] = 400;
        $this->response['token'] = "238749234823";


        return $this->response;
    }

    public function spellCheck(SpellCheckRequest $request)
    {   
        $xmlString = $request->getContent();

        $xmlObject = simplexml_load_string($xmlString);

        $postData = [
            'text' => $xmlObject->error_messages->error_message->message,
            'language' =>  $xmlObject->error_messages->error_message->message['language']
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://languagetool.org/api/v2/check',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));

        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        if(isset($response['matches']))
        {
            foreach($response['matches'] as $match)
            {
                $replace_str = [];
                foreach($match['replacements'] as $replacements)
                {
                    //create pair that need to be replaced;
                }
            }
            $response['matches'];
            $correct_message = '';
    
            $this->response['error_messages'] = [
                [
                    'message' =>   $correct_message,
                    'original_message' => $postData['text'],
                ]
            ];
        }

        return $this->response;
    }

    public function getDifferences(GetDifferencesRequest $request)
    {
        dd($request);
    }
}
