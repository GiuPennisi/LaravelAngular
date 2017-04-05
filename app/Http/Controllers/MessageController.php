<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Http\Requests;
use Auth;
use App\User;
use Response;
use App\Message;
use App\Folder;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;

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
            return response()->json(['Status' => 'ok','data' => $messages],200);
        }
        else{
            return response()->json(['Status' => 'No Content'], 204);
        }

    }
    public function getFolderContent(Request $request) {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
         if ($user){
                $collection = [];
                $folderName = $request->folder;
                $folder = Folder::where('folderName',$folderName)->where('user_id',$user->id)->get();
                if($folderName !== 'Sent')
                    $messages = Message::where('destinatario_id',$user->id)->where('folder_id',$folder[0]->id)->get();
                else
                    $messages = Message::where('user_id',$user->id)->where('folder_id',$folder[0]->id)->get();
                if ($messages){
                    foreach ($messages as $message){
                        $recipient=User::where('id',$message->destinatario_id)->get();
                        $email['to'] = $recipient[0]->email;    
                        $email['from'] = $user->email; 
                        $email['subject'] = $message->msgSubject;
                        $email['body'] = $message->msgBody;
                        $email['date'] = $message->msgSenddate;
                        array_push($collection, $email);
                    }
                    return response()->json([
                        'emails' => $collection
                    ],200);
                }else{
                    return response()->json(['Status' => 'No Content'],204);
                }
        }else{
            return response()->json(['Status' => 'Unauthorized'],401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        if ($user){
            $id = $user->id;
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $today = date('F j, Y, g:i a');
            $newDate = strtotime($today);
            $newDate=date('Y-m-d H:i:s',$newDate);
            $email = json_decode($request->email);
            $userSentFolder = Folder::where('folderName','sent')->where('user_id',$id)->first();
            foreach ($email->destinatarios_email as $key => $destino) {
                $foldersToCopy = ['inbox','sent'];

                foreach ($foldersToCopy as $folderKey => $folder) {

                    $destiny = User::where('email',$destino)->first();
                    
                    $message = new Message();
                    $message->msgSubject = $email->msgSubject;
                    $message->msgBody = $email->msgBody;
                    $message->msgSenddate = $newDate;
                    $message->user_id = $id;
                    if ($destiny) {
                        $message->destinatario_id = $destiny->id;
                    } else {
                        return response()->json(['Status' => 'destinyUserNotFound'],204);
                    }
                    
                    if ($folderKey == 0) {
                        $carpeta = Folder::where('folderName','inbox')->where('user_id',$destiny->id)->first();
                        $message->folder_id = $carpeta->id;
                    } else {
                        $message->folder_id = $userSentFolder->id;
                    }
                    
                    $d = $request->file();
                    dd(Storage::disk('local')->get('elpasajeroputo.png'));
                    foreach ($d as $file) {
                        $updFile = $file->move(storage_path('app\public\images'), $file->getClientOriginalName());
                        $message->attachmentPath = $file->getRealPath();
                    }
                    $message->save();
                }
            }
            return response()->json(['Status' => 'ok'], 200);
       }else{
            return response()->json(['Status' => 'Unauthorized'],401);
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
            return response()->json(['Status' => 'ok','data' => $message],200);
        }else{
            return response()->json(['Status' => 'No Content'],204);
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
