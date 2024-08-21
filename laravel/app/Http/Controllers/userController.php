<?php

namespace App\Http\Controllers;

use App\Events\UserStatusEv;
use App\Jobs\EnvoiMail;
use App\Mail\mailTest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Mail;

class userController extends Controller
{
    public function register(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|max:255',
            'status' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        $data['password'] = bcrypt($request->password);
        $data['image'] = "profil.png";

        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        return response()->json([ 'user' => $user, 'token' => $token]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response([ 
                'success' => false
            ]);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        // Mail::to('charly.kouasseu@gmail.com')->send(new mailTest($token));

        // $this->dispatch(new EnvoiMail('charly.kouasseu@gmail.com', $token));

        return response(['success' => true, 'token' => $token, 'user' => auth()->user()]);

    }

    public function logout(){
        $token = auth()->user()->token()->delete();

        if($token){
            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    public function get_user(){
        return response()->json(['user' => auth()->user()]);
    }

    public function all_user(){

        $all_user = User::where('id', '!=', auth()->user()->id)->get();

        return response()->json(['users' => $all_user]);
    }

    // pour recuperer tous les utilisateur avec le quelle l'utilisateur connecter
    // a dejat communiquer au mois une fois
    public function get_all_user(){

        // on recupere les id des utilisateurs 
        //
        $userIdRecepteur = Message::select('recepteur_id')->where('emetteur_id', auth()->user()->id)->distinct()->get();
            // l'id ou l'auth a envoyer un message
        //
        // 
        $userIdEmetteur = Message::select('emetteur_id')->where('recepteur_id', auth()->user()->id)->distinct()->get();
            // l'id ou l'auth a reçu un message
        // 
        
        // on recuper les utilisateurs de l'id trouver
        $users = User::whereIn('id', $userIdRecepteur)->OrwhereIn('id', $userIdEmetteur)->orderBy('updated_at', 'DESC')->get();
        

        $Message = new Message();

        $userMessage = [];
        $nbr_discussion = 0;
        $i = 0;

        // on recherge leur dernier message et le nombre de message non vu
        foreach($users as $user){

            $dernierMessage = $Message->getLastMessagesByUser(auth()->user()->id, $user->id);
            $nombre = $Message->getCountMessagesByStatus(auth()->user()->id, $user->id, 1);

            if ($nombre > 0) {
                $nbr_discussion += 1;
            }

            $userMessage[$i] = ['user' => $user, 'lastMessage' => $dernierMessage, 'nombre' => $nombre];

            $i++;
            
        }

        return response()->json([
            'users' => $userMessage,
            'nombre_discussion' => $nbr_discussion
        ]);
    }

    public function get_recepteur($id){

        $recepteur = User::find($id);

        return response()->json(['recepteur' => $recepteur]);
    }

    public function send_ligne(Request $request) {

        $user = User::find($request->emetteur_id);
        $user->status = $request->enligne;
        $user->save();

        broadcast(new UserStatusEv($request->enligne, $request->emetteur_id));
    }
}
