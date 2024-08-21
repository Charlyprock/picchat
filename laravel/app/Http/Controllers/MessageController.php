<?php

namespace App\Http\Controllers;

use App\Events\SetVueMessagesEv;
use App\Models\User;
use App\Models\Message;
use App\Events\TestName;
use App\Events\UserSatus;
use App\Events\UserStatusEv;
use App\Events\UserWriteEv;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    
    // pour recuperer les convessation de deux utilisateur. on prend l'id du recepteur en parametre
    public function get_all_messages($id) {

        $MessObj = new Message();

        $messages = $MessObj->getMessagesByUser(auth()->user()->id, $id);

        return response()->json([
            'messages' => $messages,
        ]);
    }

    public function send_message(Request $request) {

        $message = new Message();
        
        $message->message = $request->message;
        $message->heure = $request->heure;
        $message->date = $request->date;
        $message->recepteur_id = $request->recepteur_id;
        $message->emetteur_id = $request->emetteur_id;

        $message->save();

        $emetteur = User::find($request->emetteur_id);
        $recepteur = User::find($request->recepteur_id);
        
        $emetteur->updated_at = time();   // c'est pour pourvoir savoir qui est le dernier de la base de donnée a avoir envoyer un message
        $recepteur->updated_at = time();  // ainsi nous avons un ordre d'envoir de message

        $recepteur->save();
        $emetteur->save();

        $messages = $this->get_all_messages($request->recepteur_id)->original; // original car j'ai utiliser response() dans le return de get_all_messages()
      
        broadcast(new TestName($messages, $request->recepteur_id, $request->emetteur_id));

        return response()->json($messages);
    }

    public function statut_messages(Request $request)
    {
        $MessObj = new Message();

        // pour mettre le statut de tous les messages a null soit a 1 soit a 2
        $MessObj->setStatusMessagesIsNull(auth()->user()->id, $request->recepteur_id, $request->status);

        // on retourne les messages modifier
        $MessObj = new Message();
        $messages = $MessObj->getMessagesByUser(auth()->user()->id, $request->recepteur_id);
        broadcast(new SetVueMessagesEv($messages, $request->recepteur_id));
        // broadcast(new UserStatusEv($request->recepteur_id));

        return response()->json([
            'messages' => $messages,
            'emetteur_id' => $request->recepteur_id
        ]);
    }

    public function send_write(Request $request) {
        broadcast(new UserWriteEv($request->write, $request->emetteur_id, $request->recepteur_id));
    }

    
}
