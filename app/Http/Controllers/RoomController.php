<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Room::paginate(5);
        $pic = User::where('is_admin', false)->get();
        return view('ruangan.index', compact('data', 'pic'));
    }

    public function indexPetugas()
    {
        $data = Room::where('user_id', Auth::user()->id)->get(); //mengambil ruangan sesuai dengan yang dipilih.
        return view('petugas.ruangan', compact('data'));
    }
    



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('room.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_name' => ['required', 'string', 'min:5', 'max:50'],
            'room_code' => ['required', 'numeric', 'min:0', 'max:9999', 'unique:rooms,room_code'],
            'description' => ['required']
        ]);

        $simpan = [
            'room_name' => $request->input('room_name'),
            'room_code' => $request->input('room_code'),
            'user_id' => $request->input('user_id'),
            'description' => $request->input('description'),
            'slug' => $request->input('room_code') . '-' . Str::slug($request->input('room_name')) . '-' . random_int(0000, 9999)
            //001-nama-ruangan-
        ];

        Room::create($simpan);
        return redirect()->route('room.index')->with('success', 'Data berhasil disimpan');

    }

    /**
     * Display the specified resource.
     */
    public function show($param)
    {
        $data = Room::where('slug', $param)->firstOrFail();
        $pic = User::where('is_admin', false)->get();
        return view('ruangan.detail', compact('data', 'pic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Room::findOrFail($id);
        $request->validate([
            'room_name' => ['required', 'string', 'min:5', 'max:50'],
            'room_code' => ['required', 'numeric', 'min:0', 'max:9999', Rule::unique('rooms')->ignore($data->id)],
            'description' => ['required']
        ]);

        $simpan = [
            'room_name' => $request->input('room_name'),
            'room_code' => $request->input('room_code'),
            'user_id' => $request->input('user_id'),
            'description' => $request->input('description'),
            'slug' => $request->input('room_code') . '-' . Str::slug($request->input('room_name')) . '-' . random_int(0000, 9999)
        ];
        $data->update($simpan);
        return redirect()->route('room.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Room::findOrFail($id);
        $data->delete();
        return redirect()->route('room.index');
    }
}
