<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\User;
use App\Folder;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
class FolderController extends Controller
{
    /**
     * Devuelve todas las carpetas relacionadas con el usuario loggeado
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){   
            $folders = Folder::where('user_id',$id)->get();
            if($folders){
                return response()->json(["Status" => "Ok", "data" => $folders], 200);
            }else{
                return response()->json(["Status" => "Not content"], 204);
            }
    }

    /**
     * Creacion de nueva carpeta para el usuario loggeado
     *
     * @return \Illuminate\Http\Response
     */
    public function createfolder(Request $request)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
         if ($user){
            $folder = new Folder();
            $folder->folderName = $request->name;
            $folder->user_id = $user->id;
            if($folder->save()){
                return response()->json(["Status" => "Carpeta creada"], 200);
            }else{
                return response()->json(["Status" => "Error el crear la carpeta"], 500);
            }
        }else{
            return response()->json(["Status" => "Unauthorized"],401);
        }
    }


     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getFolders(Request $request)
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
         if ($user){
            $folders = Folder::where('user_id',$user->id)->get();;
            if($folders){
                return response()->json(['folders' => $folders],200);
            }else{
                return response()->json(["Status" => "Error al traer las carpetas"], 500);
            }
        }else{
            return response()->json(["Status" => "Unauthorized"],401);
        }
    }

    /**
     * brings all folders for a user
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
