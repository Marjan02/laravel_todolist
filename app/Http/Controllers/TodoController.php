<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = DB::table('todos')->where('user_id', '=', Auth::user()->id)->get(); // Ngambil data dari table todos buat di tampilin di route home
        return view('home', ['todos' => $todos], ['title' => 'Todolist']); // mengembalikan view home, membuat variable todos buat bisa di panggil di views home, dan tittlenya menjadi Todolist
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) // parameter request ini buat bisa kirim request
    {
        // validate the form
        $request->validate([
            'task' => 'required|max:200' // validasi form buat ngirim atau store data
        ]);

        // store the data
        DB::table('todos')->insert([
            'user_id' => Auth::user()->id,
            'task' => $request->task
        ]); // memasukan request datanya ke table todos

        return redirect('/')->with('status', 'Task added!');  // redirect = buat ngelihin si urlnya ke /, with = ngirim informasi ke view kayak pop up atau notifikasi 
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

    public function complete(Request $request, $id)
    {
        $request->validate([
            'complete' => 'required|max:200' // validasi form buat update data
        ]);

        DB::table('todos')->where('id', $id)->update([ // nyari di dalem table todos ada gak id yang di cari atau yang user pilih, trus ngirim requestnya buat di ubah
            'complete' => $request->complete
        ]);

        return redirect('/')->with('status', 'Task complate!'); // redirect = buat ngelihin si urlnya ke /, with = ngirim informasi ke view kayak pop up atau notifikasi 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) // parameter request ini buat bisa kirim request, id untuk ubah datanya jadi lebih spesifik di samain sama idnya
    {
        // validate the form
        $request->validate([
            'task' => 'required|max:200' // validasi form buat update data
        ]);

        // update the data
        DB::table('todos')->where('id', $id)->update([ // nyari di dalem table todos ada gak id yang di cari atau yang user pilih, trus ngirim requestnya buat di ubah
            'task' => $request->task
        ]);

        // redirect
        return redirect('/')->with('status', 'Task updated!'); // redirect = buat ngelihin si urlnya ke /, with = ngirim informasi ke view kayak pop up atau notifikasi 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) // parameter id untuk delete datanya jadi lebih spesifik di samain sama idnya
    {
        // delete the todo
        DB::table('todos')->where('id', $id)->delete(); // nyari di dalem table todos ada gak id yang di cari atau yang user pilih, trus ngirim requestnya buat di hapus

        // redirect
        return redirect('/')->with('status', 'Task removed!'); // redirect = buat ngelihin si urlnya ke /, with = ngirim informasi ke view kayak pop up atau notifikasi 
    }
}
