<?php

namespace App\Http\Controllers;

use App\Screenshot;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ScreenshotController extends Controller
{
    public function insertScreenshot(Request $request)
    {
        $user = (object) ['image' => ""];
        $username = $request->input('user');
        $key = $request->input('key');
        $tab = $request->input('tab'); 
        if ($request->hasFile('image')) {
            $original_filename = $request->file('image')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './upload/sceenshot/';
            $image = 'U-'.$key.'.' . $file_ext;
            
            if ($request->file('image')->move($destination_path, $image)) {
                $new_screenshot = [
                    'username' => $username,
                    'key' => $key,
                    'tab' => $tab,
                    'img' => $image
                ];
    
                Screenshot::create($new_screenshot);

                return response()->json([
                    'statuscode' => 200,
                    'message' => 1
                ]);
            } else {
                return response()->json([
                    'statuscode' => 500,
                    'message' => 'Cannot upload file'
                ]);
                return $this->responseRequestError();
            }
        } else {
            response()->json([
                'statuscode' => 500,
                'message' => 'File not found'
            ]);
            return $this->responseRequestError();
        }
    }
}