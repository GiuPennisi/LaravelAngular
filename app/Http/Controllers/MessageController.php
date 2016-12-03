<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            $message = new Message();
            $sentMessage = new Message();
            $message->msgSubject = $request->msgSubject;
            $sentMessage->msgSubject = $request->msgSubject;
            
            $message->msgBody = $request->msgBody;
            $sentMessage->msgBody = $request->msgBody;
            
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $today = date('F j, Y, g:i a');
            $newDate = strtotime($today);
            $newDate=date('Y-m-d H:i:s',$newDate);
            $message->msgSenddate = $newDate;
            $sentMessage->msgSenddate = $newDate;

            $message->user_id = $id;
            $sentMessage->user_id = $id;
            $destinatario=User::where('email',$request->destinatario_email)->get();
            if ($destinatario){
                $destinatario_id=$destinatario[0]->id;
                $message->destinatario_id = $destinatario_id;
                $sentMessage->destinatario_id = $destinatario_id;
            }else{
                return response()->json(['Status' => 'userNotFound'],204);
            }
            
            $carpeta = Folder::where('folderName','inbox')->where('user_id',$destinatario_id)->get();
            $userSentFolder = Folder::where('folderName','sent')->where('user_id',$id)->get();

            if ($carpeta && $userSentFolder){
                $message->folder_id=$carpeta[0]->id;
                $sentMessage->folder_id = $userSentFolder[0]->id;
            }else{
                return response()->json(['Status' => 'folderNotFound'],204);
            }

            if($message->save() && $sentMessage->save()){
                return response()->json(['Status' => 'ok'], 200);
            }else{
                return response()->json(['Status' => 'Error'], 500);
            }
       }else{
            return response()->json(['Status' => 'Unauthorized'],401);
       }
    }

    public function viewMails(){
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $collection = array();
        $email = null;
        if ($user){
                $inbox = Folder::where('folderName','Inbox')->where('user_id',$user->id)->get();
                $messages = Message::where('destinatario_id',$user->id)->where('folder_id',$inbox[0]->id)->get();
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
