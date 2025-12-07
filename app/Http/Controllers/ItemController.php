<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Item::paginate(5);
        $room = Room::all();
        return view('barang.index', compact('data', 'room'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => ['required', 'string', 'min:3', 'max:30'],
            'room_id' => ['required', 'integer', Rule::exists('rooms', 'id')],
            'item_code' => ['required', 'numeric', 'min:0', 'max:9999', 'unique:items,item_code'],
            'date_purchase' => ['required'],
            'image' => ['required', 'file', 'mimes:png,jpg,jpeg,svg,webp,heic'],
            'description' => ['required'],
            'status' => ['required', 'in:good,maintenance,broke']
        ]);
        // data yang harus disimpan : disesuaikan dengan database
        $simpan = [
            'item_name' => $request->input('item_name'),
            'room_id' => $request->input('room_id'),
            'item_code' => $request->input('item_code'),
            'date_purchase' => $request->input('date_purchase'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'slug' => Str::slug($request->item_name) . random_int(0, 9999) // illuminate\support
        ];
        // kondisi saat ada nilai input file gambar
        if ($request->hasFile('image')) {
            $gambar = $request->file('image');
            $path = 'public/images/items';
            $ext = $gambar->getClientOriginalExtension();
            $nama = 'my_items_' . Carbon::now('Asia/jakarta')->format('Ymdhis') . '.' . $ext; //myproduct_20251206103450.png
            $simpan['image'] = $nama;
            // menyimpan gambar ke storage : 
            $gambar->storeAs($path, $nama);
        }
        Item::create($simpan);
        return redirect()->route('item.index')->with('success', 'Product Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($param)
    {
        $data = Item::where('slug', $param)->firstOrFail();
        $room = Room::all();
        return view('barang.detail', compact('data', 'room'));
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

        $data = Item::findOrFail($id);
        $request->validate([
            'item_name' => ['required', 'string', 'min:3', 'max:30'],
            'room_id' => ['required', 'integer', Rule::exists('rooms', 'id')],
            'item_code' => ['required', 'numeric', 'min:0', 'max:9999', Rule::unique('items')->ignore($data->id)],
            'date_purchase' => ['required'],
            'image' => ['file', 'mimes:png,jpg,jpeg,svg,webp,heic'],
            'description' => ['required'],
            'status' => ['required', 'in:good,maintenance,broke']
        ]);
        // data yang harus disimpan : disesuaikan dengan database
        $simpan = [
            'item_name' => $request->input('item_name'),
            'room_id' => $request->input('room_id'),
            'item_code' => $request->input('item_code'),
            'date_purchase' => $request->input('date_purchase'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'slug' => Str::slug($request->item_name) . random_int(0, 9999) // illuminate\support
        ];
        // kondisi saat ada nilai input file gambar
        if ($request->hasFile('image')) {

            $data_lama = 'public/images/items/' . $data->image;

            if ($data->image && Storage::exists($data_lama)) {
                Storage::delete($data_lama);
            }


            $gambar = $request->file('image');
            $path = 'public/images/items';
            $ext = $gambar->getClientOriginalExtension();
            $nama = 'my_items_' . Carbon::now('Asia/jakarta')->format('Ymdhis') . '.' . $ext; //myproduct_20251206103450.png
            $simpan['image'] = $nama;
            // menyimpan gambar ke storage : 
            $gambar->storeAs($path, $nama);
        }

        $data->update($simpan);

        return redirect()->route('item.index')->with('success', 'Product Created');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
