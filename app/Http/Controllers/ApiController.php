<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;

class ApiController extends Controller
{
    public function init(Request $request){
        $url = 'https://weather-ydn-yql.media.yahoo.com/forecastrss';
        $app_id = env('APP_ID');
        $consumer_key = env('APP_CONSUMER_KEY');
        $consumer_secret = env('APP_CONSUMER_SECRET');
        $query = array(
            'location' => $request->post('city'),
            'format' => 'json',
        );
        $oauth = array(
            'oauth_consumer_key' => $consumer_key,
            'oauth_nonce' => uniqid(mt_rand(1, 1000)),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0'
        );
        $base_info = $this->buildBaseString($url, 'GET', array_merge($query, $oauth));
        $composite_key = rawurlencode($consumer_secret) . '&';
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;
        $header = array(
            $this->buildAuthorizationHeader($oauth),
            'X-Yahoo-App-Id: ' . $app_id
        );
        $options = array(
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $url . '?' . http_build_query($query),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        );
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);
        //print_r($response);
        $return_data = json_decode($response);
        
        $city = $return_data->location->city;
        $country = $return_data->location->country;
        $lat = $return_data->location->lat;
        $long =  $return_data->location->long;

        $humidity = $return_data->current_observation->atmosphere->humidity;
        $visibility = $return_data->current_observation->atmosphere->visibility;
        $pressure = $return_data->current_observation->atmosphere->pressure;

        

        echo json_encode([
            'city' => $city, 
            'country' => $country, 
            'lat' => $lat, 
            'long' => $long,
            'humidity' => $humidity,
            'visibility' => $visibility,
            'pressure' => $pressure, 
        ]);

        $this->saveData($country, $city, $humidity, $visibility, $pressure);
    }

    public function buildBaseString($baseURI, $method, $params){
        $r = array();
        ksort($params);
        foreach ($params as $key => $value) {
            $r[] = "$key=" . rawurlencode($value);
        }
        return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
    }

    public function buildAuthorizationHeader($oauth){
        $r = 'Authorization: OAuth ';
        $values = array();
        foreach ($oauth as $key=>$value) {
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        }
        $r .= implode(', ', $values);
        return $r;
    }

    public function saveData($country, $city, $humidity, $visibility, $pressure){
        $model = new City;
        $model->country = $country;
        $model->city = $city;
        $model->humidity = $humidity;
        $model->visibility = $visibility;
        $model->pressure = $pressure;

        $model->save();
    }

    public function history(){
        $cities = City::all();
        return view('history', compact('cities'));
    } 
}
