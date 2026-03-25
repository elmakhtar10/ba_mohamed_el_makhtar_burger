<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BurgerController extends Controller
{
    public function index()
    {
        $burgers = Burger::orderByDesc('created_at')->get();

        return view('burgers.index', compact('burgers'));
    }

    public function create()
    {
        return view('burgers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('burgers', 'public');
        }

        Burger::create($data);

        return redirect()->route('burgers.index')->with('success', 'Burger ajouté avec succès.');
    }

    public function edit(Burger $burger)
    {
        return view('burgers.edit', compact('burger'));
    }

    public function update(Request $request, Burger $burger)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('image')) {
            if ($burger->image_path) {
                Storage::disk('public')->delete($burger->image_path);
            }

            $data['image_path'] = $request->file('image')->store('burgers', 'public');
        }

        $burger->update($data);

        return redirect()->route('burgers.index')->with('success', 'Burger modifié avec succès.');
    }

    public function destroy(Burger $burger)
    {
        if ($burger->image_path) {
            Storage::disk('public')->delete($burger->image_path);
        }

        $burger->delete();

        return redirect()->route('burgers.index')->with('success', 'Burger supprimé avec succès.');
    }

    public function archive(Burger $burger)
    {
        $burger->update(['is_archived' => ! $burger->is_archived]);

        return redirect()->route('burgers.index')->with('success', 'Statut du burger mis à jour.');
    }
}
