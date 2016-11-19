<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use App\User;

use App\Message;

use App\Folder;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::where('user_id',$user_id);
        if ($messages){
            return response()->json(["Status" => "ok","data" => $messages],200);
        }
        else{
            return response()->json(["Status" => "No Content"], 204);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        if (Auth::check()){
            $id = Auth::id();
            $message = new Message();
            $message->msgSubject = $request->msgSubject;
            
            $message->msgBody = $request->msgBody;
            
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $today = date('F j, Y, g:i a');
            $newDate = strtotime($today);
            $newDate=date('Y-m-d H:i:s',$newDate);
            $message->mgsSenddate = $newDate;

            $message->user_id = $id;
            
            $destinatario=User::where("email",$request->destinatario_email)->get();
            if ($destinatario){
                $destinatario_id=$destinatario[0]->id;
                $message->destinatario_id = $destinatario_id;
            }else{
                return response()->json(["Status" => "userNotFound"],204);
            }
            
            $carpetas=Folder::where("folderName",$request->folderName)->get();
            if ($carpetas){
                foreach($carpetas as $carpeta){
                    if ($carpeta->user_id == $destinatario_id){
                        $carpeta_id=$carpeta->id;
                        $message->folder_id=$carpeta_id;
                    }
                }
            }else{
                return response()->json(["Status" => "folderNotFound"],204);
            }

            if (!($carpeta_id)){
                return response()->json(["Status" => "userNotFound"],204);
            }

            if($message->save()){
                return response()->json(["Status" => "ok"], 200);
            }else{
                return response()->json(["Status" => "Error"], 500);
            }
       }else{
            return response()->json(["Status" => "Unauthorized"],401);
       }
    }

    public function viewMails($id){
        if (Auth::check()){
            $user=User::find($id);
            if ($user){
                $messages=Message::where("user_id",$id);
                if ($messages){
                    $inbox=Folder::where("folderName","Inbox");
                    if ($inbox){
                        foreach ($messages as $message){
                            if ($message->folder_id == $inbox[0]->id){
                                $collection = collect($message);    
                            }
                        }
                    }else{
                        return response()->json(["Status" => "inboxFolderNotFound"],204);
                    }
                }else{
                    return response()->json(["Status" => "No Content"],204);
                }
            }else{
                return response()->json(["Status" => "userNotFound"],204);
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
        $message = Message::find($id);
        if ($message){
            return response()->json(["Status" => "ok","data" => $message],200);
        }else{
            return response()->json(["Status" => "No Content"],204);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
