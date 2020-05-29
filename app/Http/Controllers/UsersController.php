<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Gets all sensors information
        $users=User::all();
        return view('users.index', ['users' => $users]);
    }

    public function profile(){
        return view('users.profile');
    }

    public function update_avatar(Request $request){
        // configure with favored image driver (gd by default)
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename='/avatars/' . time() . '.' . $avatar->getClientOriginalExtension();
            Storage::disk('public')->put($filename, File::get($avatar));

            $user = Auth::user();
            $user->avatar = '/uploads'. $filename;
            $user->save();
        }
        return redirect('/dashboard/profile');
    }

    public function togglePermissions($id)
    {
        //Chama a variavel user que fica com registo da base de dados
        $user = User::findOrFail($id);

        //se o campo role for igual a admin, muda para user, se nao for muda para admin
        if($user->role == 'admin'){
            $user->update(array('role'=>'user'));
        }else{
            $user->update(array('role'=>'admin'));

        }

        return redirect('/dashboard/users')->with('success', 'Informação do Utilizador alterada com sucesso!');

    }
}
