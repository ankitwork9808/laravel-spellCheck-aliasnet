<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SpellCheckRequest;
use App\Http\Requests\GetTokenRequest;
use App\Http\Requests\GetDifferencesRequest;
use App\Models\User;

class ApiController extends Controller
{    
    /**
     * getToken
     *
     * @param  mixed $request
     * @return void
     */
    public function getToken(Request $request)
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

        //Get auth details
        $auth_user = $request->server->get('PHP_AUTH_USER');
        $auth_password = $request->server->get('PHP_AUTH_PW');
        
        //do authentication
        auth()->attempt(array(
            'email' => $auth_user, 
            'password' => $auth_password 
        ));

        if(auth()->check())
        {
            $user = User::where(['email' => $auth_user])->first();
           
            //Delete any previous token
            $user->tokens()->delete();
            $token = $user->createToken('User-' . $user->id);

            $this->response['status'] = true;
            $this->response['code'] = 200;
            $this->response['token'] = $token->plainTextToken;

        } else {

            $this->response['status'] = false;
            $this->response['code'] = 203;
            $this->response['errors'] = "Unable to login";
        }


        return $this->response;
    }

    public function spellCheck(Request $request)
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

    public function getDifferences(Request $request)
    {
        dd($request);
    }
}
