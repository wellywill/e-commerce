<?php

namespace App\Http\Controllers;

use App\Models\registrasi;
use App\Http\Requests\StoreregistrasiRequest;
use App\Http\Requests\UpdateregistrasiRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('registrasi.registrasi');
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


        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048', // max 2MB
        ]);

        // Upload gambar jika ada
        $validated['password'] = Hash::make($validated['password']);
        if ($request->file('image')) {
            $validated['image'] = $request->file('image')->store('user-image');
        } else {
            $validated['image'] = 'user-image/default.png';
        }

        // Simpan user
        User::create($validated);

        // Redirect ke login atau halaman lain
        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    /**
     * Display the specified resource.
     */
    public function show(registrasi $registrasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(registrasi $registrasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateregistrasiRequest $request, registrasi $registrasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(registrasi $registrasi)
    {
        //
    }
}
