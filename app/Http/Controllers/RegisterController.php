<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use Hash;
use Response;
use App\User;
use App\Folder;
use App\Country;
use App\Province;
use App\City;
class RegisterController extends Controller
{
    /**
     * Devuelve todas las carpetas relacionadas con el usuario loggeado
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
     {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['signup','countries','provinces', 'cities']]);
     }

    public function index(){

    }

    /**
     * Creacion de nueva carpeta para el usuario loggeado
     *
     * @return \Illuminate\Http\Response
     */
     public function signup(Request $request)
    {
        $credentials = $request->only('birthday','lastname','name','username','email','password');
        $credentials['password'] = Hash::make( $credentials['password'] );
        $cities = City::all();
        $cityRequest = $request->only('city');

        foreach($cities as $cityAux) {
            if ($cityAux->city === $cityRequest['city']) {
               $credentials['city_id'] = $cityAux->id;
            }
          }

        try {

            $user = User::create($credentials);

            $folders  = ['Inbox','Sent','Starred','Drafts','Important','Spam'];

            foreach ($folders as $folderName) {
                $folder = new Folder();
                $folder->folderName = $folderName;
                $folder->user_id = $user->id;
                $folder->save();
            }

        } catch (Exception $e) {
            return Response::json(['error' => 'User already exists.'], HttpResponse::HTTP_CONFLICT);
        }

        $token = JWTAuth::fromUser($user);

        return Response::json(compact('token'));
    }

    /*
    * Devuelve el conjunto de paises
    */
    public function countries(){
      $countries=Country::all();
      if ($countries){
        $countriesArray = [];
        foreach ($countries as $country) {
          array_push($countriesArray, $country->country);
        }
        return response()->json(["Status"=>"Ok","data"=>$countriesArray],200);
      }else{
        return response()->json(["Status"=>"No Content"],204);
      }
    }

    /*
    * Se le pasa como parametro el id del pais elegido
    * Devuelve el conjunto de provincias asociadas a ese country_id
    */
    public function provinces (Request $request){
      $country = Country::where('country',$request->country)->get();

      if ($country){
          $provinces = Province::where('country_id',$country[0]->id)->get();
          $provinceArray = [];
          foreach ($provinces as $province) {
            array_push($provinceArray, $province->province);
          }
          if ($provinceArray){
            return response()->json(["Status"=>"Ok","data"=>$provinceArray],200);
          }else{
            return response()->json(["Status"=>"no_province"],204);
          }
      }else{
        return response()->json(["Status"=>"no_country"],204);
      }
    }

    public function cities (Request $request){
      $province = Province::where('province',$request->province)->get();
      if ($province){
          $cityArray= [];
          $cities = City::where('province_id',$province[0]->id)->get();
          foreach ($cities as $city) {
            array_push($cityArray, $city->city);
          }
          if ($cityArray){
            return response()->json(["Status"=>"Ok","data"=>$cityArray],200);
          }else{
            return response()->json(["Status"=>"no_province"],204);
          }
      }else{
        return response()->json(["Status"=>"no_country"],204);
      }
    }
}
