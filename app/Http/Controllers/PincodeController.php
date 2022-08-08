<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PincodeController extends Controller
{
    public function index(){
        // $PostOffice = [1];
        // return view('pincode')->with("PostOffice" , $PostOffice);
        return view('pincode');
    }
    public function searchPincode(Request $request){
        $pincode = $request->search;
        $url = "https://api.postalpincode.in/pincode/$pincode";
        $access_token = '';
        $method = "GET";
        $post_data = '';
        $apiCall = ($this->call($url, $access_token, $method, $post_data));
        // dd($apiCall);
        return $apiCall;
        
        
    }

    private function call($url, $access_token, $method, $post_data = array())
        {
            //echo "access_token:".$access_token;
            $client = new Client();
            if ($method == 'POST') {
                try {
                    $response = $client->request('POST', $url, [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer ' . $access_token,
                        ],
                        'body' => json_encode($post_data),
                        'verify' => false
                        // 'form_params' => $post_data,
                        //'debug' => true
                        //'multipart' => $post_data
                        //'json' => json_encode($post_data)
                    ]);
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    //dd($e);
                    if ($e->getResponse()->getStatusCode() == 401) {
                        return json_encode(array('status' => '0', 'message' => "Unauthorized token.Please reconnect EKM integration", 'code' => 401));
                    } else {
                        return json_encode(array('status' => '0', 'message' => $e->getMessage()));
                    }
                } catch (\Exception $e) {
                    return json_encode(array('status' => '0', 'message' => $e->getMessage()));
                }
            } elseif ($method == 'PUT') {
                try {
                    $response = $client->request('PUT', $url, [
                        'headers' => [
                            'Accept'                => 'application/json',
                            'Content-Type' => 'application/json',
                            'Authorization'         => 'Bearer ' . $access_token,
                        ],
                        'body' => json_encode($post_data),
                        'verify' => false
                        //'debug'=>false
                        //'multipart' => $postdata
                    ]);
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    if ($e->getResponse()->getStatusCode() == 401) {
                        return json_encode(array('status' => '0', 'message' => "Unauthorized token.Please reconnect EKM integration", 'code' => 401));
                    } else {
                        return json_encode(array('status' => '0', 'message' => $e->getMessage()));
                    }
                } catch (\Exception $e) {
                    return json_encode(array('status' => '0', 'message' => $e->getMessage()));
                }
            } elseif ($method == 'DELETE') {
                try {
                    $response = $client->request('DELETE', $url, [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Authorization'  => 'Bearer ' . $access_token
                        ],
                        'verify' => false
                    ]);
                    //dd($response);
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    if ($e->getResponse()->getStatusCode() == 401) {
                        return json_encode(array('status' => '0', 'message' => "Unauthorized token.Please reconnect EKM integration", 'code' => 401));
                    } else {
                        return json_encode(array('status' => '0', 'message' => $e->getMessage()));
                    }
                } catch (\Exception $e) {
                    return json_encode(array('status' => '0', 'message' => $e->getMessage()));
                }
            } else {
                try {
                    $response = $client->request('GET', $url, [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Authorization'  => 'Bearer ' . $access_token
                        ],
                        'query' => $post_data,
                        'debug' => false,
                        'verify' => false
                    ]);
                } 
                catch (\GuzzleHttp\Exception\RequestException $e) {
                    //dd($e);
                    if ($e->getResponse()->getStatusCode() == 401) {
                        return json_encode(array('status' => '0', 'message' => "Unauthorized token.", 'code' => 401));
                    } else {
                        return json_encode(array('status' => '0', 'message' => $e->getMessage()));
                    }
                } catch (\Exception $e) {
                    return json_encode(array('status' => '0', 'message' => $e->getMessage()));
                }
            }
    
            if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) { // 200 OK
                $response_data = $response->getBody()->getContents();
                return $response_data;
            } else {
                return '';
            }
        }

}
