<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Category; // Assurez-vous d'importer le modèle Category
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class NoteController extends Controller
{
    public function index()
    {
        // Récupérer les notes avec les catégories associées
        $notes = Note::with('category')->where('user_id', Auth::id()) ->paginate(9);
        
        
        // Renvoyer le composant Notes avec les données
        return Inertia::render('Notes', [
            'notes' => $notes,
        ]);
    }

    // Ajouter une note
    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);
    
        // Création de la note
        $note = Note::create([
            'user_id' => Auth::id(),
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'category_id' => $validatedData['category'],
            'image_path' => $request->file('image') ? $request->file('image')->store('images', 'public') : null,
        ]);
    
        // Redirection après création
        return Inertia::location('/notes');
    }

    // Modifier une note
    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);
        $this->authorize('update', $note);

        $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'category' => 'exists:categories,id', // Validation pour s'assurer que la catégorie existe
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $note->image_path = $path; // Mettre à jour le chemin de l'image
        }

        // Mettre à jour uniquement les champs autorisés
        $note->update($request->only(['title', 'content', 'category']));

        // Mettre à jour la catégorie si elle est fournie
        if ($request->has('category')) {
            $note->category_id = $request->category; // Assurez-vous d'utiliser category_id
        }

        return response()->json($note);
    }

    // Supprimer une note
    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $this->authorize('delete', $note);

        $note->delete();
        return response()->json(null, 204);
    }

    // Récupérer les catégories
    public function getCategories()
    {
        $categories = Category::all(); // Assurez-vous d'importer le modèle Category
        return response()->json($categories);
    }
}