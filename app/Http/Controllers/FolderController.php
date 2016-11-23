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
        if (Auth::check()){
            $id = Auth::id();

            $folders = Folder::where('user_id',$id)->get();
            if($folders){
                return response()->json(["Status" => "Ok", "data" => $folders], 200);
            }else{
                return response()->json(["Status" => "Not content"], 204);
            }
        }else{
            return response()->json(["Status" => "Unauthorized"],401);
        } 
    }

    /**
     * Creacion de nueva carpeta para el usuario loggeado
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Auth::check()){
            $id=Auth::id();
            $folder = new Folder();
            $folder->folderName = $request->folderName;
            $folder->user_id = $user_id;

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
    public function show($id)
    {
        if (Auth::check()){
            $user_id = Auth::id();
            $folder = Folder::find($id);
            if ($folder){
                if ($user_id == $folder->user_id){
                    return response()->json(["Status" => "Ok","data" => $folder],200);
                }
                else{
                    return response()->json(["Status" => "Forbidden"],403);
                }
            }else{
                return response()->json(["Status" => "No Content"],204);
            }

        }else{
            return response()->json(["Status" => "Unauthorized"],401);
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        if (Auth::check()){
            $user_id = Auth::id();
            $folder = Folder::find($id)->where("user_id",$user_id)->get();
            if ($folder){
                $folder->folderName = $request->folderName;
            }else{
                return response()->json(["Status"=>"No Content"],204);
            }

            if ($folder->save()){
                return response()->json(["Status"=>"Ok"],200);
            }else{
                return response()->json(["Status" => "Internal Server Error"],500);
            }
        }else{
            return response()->json(["Status" => "Unauthorized"],401);
        }

    }

    /**
     * SI ELIMINO LA CARPETA, SE ELIMINAN EN CASCADA LOS MENSAJES ASOCIADOS A ELLA?
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
