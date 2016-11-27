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
       $this->middleware('jwt.auth', ['except' => ['signup']]);
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
        $credentials = $request->only('birthday','city','lastname','name','username','email','password');
        $credentials['password'] = Hash::make( $credentials['password'] );

        try {
            $user = User::create($credentials);

            $folders  = ['Inbox','Starred','Drafts','Important','Spam'];

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

    public function countries(){
      $countries=Country::all();
      if ($countries){
        return response()->json(["Status"=>"Ok","data"=>$countries],200);
      }else{
        return response()->json(["Status"=>"No Content"],204);
      }
    }
    /*
    *
    * Se le pasa como parametro el id del pais elegido
    * Devuelve el conjunto de provincias asociadas a ese country_id
    */
    public function provinces (Request $request){
      $country=Country::where('country','=',$request->country_name);
      $provinces = Province::find($country->id);
      if ($provinces){
        return response()->json(["Status"=>"Ok","data"=>$provinces],200);
      }else{
        return response()->json(["Status"=>"No Content"],204);
      }
    }

    public function cities (Request $request){
      $province_id=Province::where('province','=',$request->province_name);
      $cities = Province::find($province->id);
      if ($cities){
        return response()->json(["Status"=>"Ok","data"=>$cities],200);
      }else{
        return response()->json(["Status"=>"No Content"],204);
      }
    }
}
