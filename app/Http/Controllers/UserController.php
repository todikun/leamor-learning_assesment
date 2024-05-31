<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::whereRole('student')->get();
        return view('pages.user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.user.create');
    }

    public function register()
    {
        return view('auth.register');
    }
    public function registerStore(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            'username'=>'required|unique:users',
            'email'=>'unique:users',
            'password'=>'required',
            'konfirmasi_password'=>'required|same:password',
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email ?? null,
            'sekolah' => $request->sekolah ?? null,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('login', ['q'=>$request->role])->with('success', 'Akun berhasil dibuat');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            'username'=>'required|unique:users',
            'password'=>'required',
            'konfirmasi_password'=>'required|same:password',
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'student',
        ]);

        return redirect()->route('user.index')->with('success', 'Data berhasil disimpan');
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
        $data = User::find($id);
        return view('pages.user.edit', compact('data'));   
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
        $user = User::find($id);
        if ($user->username == $request->username) {
            $request->validate([
                'nama'=>'required',
                'username'=>'required',
                'konfirmasi_password'=>'same:password',
            ]);
        } else {
            $request->validate([
                'nama'=>'required',
                'username'=>'required|unique:users',
                'konfirmasi_password'=>'same:password',
            ]);
        }
        
        $user->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'role' => 'student',
        ]);

        return redirect()->route('user.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();
        return redirect()->route('user.index')->with('success', 'Data berhasil dihapus');
    }
}
