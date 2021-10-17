<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class UserController extends Controller
{

    private $apiTorre;
    private $apiSearchTorre;
    private $apiAWS;

    public function __construct(){
        $this->apiTorre = new Client(['base_uri' => env('API_Torre')]);
        $this->apiSearchTorre = new Client(['base_uri' => env('API_Torre_Search')]); 
        $this->apiAWS = new Client(['base_uri' => env('API_AWS')]);    
    }
    
    public function getAll()
    {
        return User::all();
    }

    public function insertUser(Request $request)
    {
        $obj = $request->all();
        User::create($obj);

        return response()->json([
            'statuscode' => 200,
            'message' => 1
        ]);
    }

    public function deleteAll(){
        User::destoy();

        return response()->json([
            'statuscode' => 200,
            'message' => 1
        ]);
    }
    
    public function getUserFromTorre($user)
    {        
        $data = $this->apiTorre->get('api/bios/'.$user)->getBody();
        return json_decode($data, true);
    }

    public function searchPeopleFromTorre(Request $request, $params)
    {
        $name = $request->input('name');
        if (isset($name)) {
            $data = $this->apiSearchTorre->post('people/_search?'.$params, ['json' => ['name' => ['term' => $name]]])->getBody();
        } else {
            $data = $this->apiSearchTorre->post('people/_search?'.$params)->getBody();
        }
        
        return json_decode($data, true);
    }

    public function analyzeUsersData()
    {
        $data = $this->apiAWS->post('mousetracking')->getBody();
        $Response = json_decode(json_decode($data, true)['body']);
        $tempUsers = [];
        foreach ($Response as $row => $value){
            if(isset($Response[$row]->username)){
                $tempUsers[$Response[$row]->username] = [
                    'name' => $Response[$row]->name,
                    'key'=> $Response[$row]->key
                ];
            }
        }
        User::truncate();
        foreach ($tempUsers as $key => $value) {
            $variable = [
                'username' => $key,
                'name' => $value["name"],
                'key' => $value["key"]
            ];

            User::create($variable);
        }
        return response()->json([
            'statuscode' => 200,
            'message' => 1
        ]);
    }
}