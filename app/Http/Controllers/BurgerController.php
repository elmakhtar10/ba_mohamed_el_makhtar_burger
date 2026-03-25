<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BurgerController extends Controller
{
    public function catalogue(Request $request)
    {
        $query = Burger::query()->where('is_archived', false);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->string('search') . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        $burgers = $query->orderBy('name')->get();

        return view('catalogue.index', compact('burgers'));
    }

    public function catalogueShow(Burger $burger)
    {
        if ($burger->is_archived) {
            abort(404);
        }

        return view('catalogue.show', compact('burger'));
    }

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
            'category' => ['nullable', 'string', 'in:' . implode(',', \App\Models\Burger::CATEGORIES)],
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
            'category' => ['nullable', 'string', 'in:' . implode(',', \App\Models\Burger::CATEGORIES)],
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
