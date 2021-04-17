<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RefferController extends Controller
{

    public function index($name)
    {
        $user = User::where('name',$name)->first();
        return view('refferReg',compact('user'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $ref_users = User::where('refferBy',$request->input('refferBy'))->count();
        $refferal = User::where('name',$request->input('refferBy'))->first();
        if($ref_users == 0){
            $CB = rand(25,50);
            $refferal->amount = $refferal->amount + $CB;
            $refferal->update();
        }
        if($ref_users == 1){
            $CB = rand(5,10);
            $refferal->amount = $refferal->amount + $CB;
            $refferal->update();
        }

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->refferBy = $request->input('refferBy');
        if($ref_users < 2){
            $user->amount = ($CB*5)/100;
        }
        $user->save();
        return redirect()->route('login');
    }

    public function show($name)
    {
        $earning = User::select('amount')->where('name',$name)->first();
        $users = User::where('refferBy',$name)->get();
        return view('refferList', compact('users','name','earning'));
    }

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
