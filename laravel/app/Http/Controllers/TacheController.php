<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use App\Models\User;
use Illuminate\Http\Request;


class TacheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taches = Tache::all();
        $user = User::all();
        return response()->json(['taches' => $taches, 'users' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profil()
    {
        // $profil = Tache::where('user_id', auth()->user()->id)->get();
        $profil = User::find(auth()->user()->id);

        return response()->json($profil->tache);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $taches = new Tache();
        
        $taches->nom = $request->nom;
        $taches->user_id = auth()->user()->id;

        if($request->hasFile('image')){
            $images = $request->file('image');

            $image_name = array();
            $i = 0;
            foreach($images as $image){
            
                $image_name_pro = time() . $i . "." . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $image_name_pro);
                $image_name[$i] = $image_name_pro;
                $i ++;
            }
            
            $taches->image = json_encode($image_name);
        }

        $taches->save();

        $taches = Tache::all();
        return response()->json($taches);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $taches = Tache::find($id);

        $taches->delete();

        $images = json_decode($taches->image);

        foreach($images as $image){
            unlink(public_path('images').'/'.$image);
            // Storage::delete('public/image/' . $image);
        }
        
        $taches = Tache::all();
        return response()->json($taches);
    }

    public function delete_user($id){

        $user = User::find($id);
        $user->delete();


        $taches = Tache::all();
        $user = User::all();
        return response()->json(['taches' => $taches, 'users' => $user]);
    }
}
