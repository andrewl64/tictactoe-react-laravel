<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

use App\Models\User;

class ProfilePicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->fill($request->validate([
            'img' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
        ]));

        $img = $request->file('img');
        $name_gen = hexdec(uniqid()).'.'.$img->extension();

        $img_file = Image::read($img)->resize(225,225)->encode();
        $save_url = 'uploads/admin_imgs/'.$name_gen;
        if(Storage::disk('public')->exists('uploads/admin_imgs/'.$user->getOriginal('img'))) {
            Storage::disk('public')->delete('uploads/admin_imgs/'.$user->getOriginal('img'));
        }

        Storage::disk('public')->put($save_url, $img_file);

        $user->img = $name_gen;
        $user->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
