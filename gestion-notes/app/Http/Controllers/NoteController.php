<?php

namespace App\Http\Controllers;

use App\Mail\NoteCreated;
use App\Models\Note;
use App\Models\Category; // Assurez-vous d'importer le modèle Category
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class NoteController extends Controller

{
    use AuthorizesRequests;
    public function index()
    {
        // Récupérer les notes avec les catégories associées, triées par date de création décroissante
        $notes = Note::with('category')
                     ->where('user_id', Auth::id())
                     ->orderBy('created_at', 'desc') // Tri par date de création, les plus récentes en premier
                     ->paginate(6);
        
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
    
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
    
        // Envoyer l'e-mail de confirmation à l'utilisateur
        Mail::to($user->email)->send(new NoteCreated($note));
    
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
    
        // Mettre à jour le chemin de l'image si un nouveau fichier est fourni
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si nécessaire
            if ($note->image_path) {
                Storage::disk('public')->delete($note->image_path);
            }
    
            $path = $request->file('image')->store('images', 'public');
            $note->image_path = $path; // Mettre à jour le chemin de l'image
        }
    
        // Mettre à jour uniquement les champs autorisés
        $note->update($request->only(['title', 'content']));
    
        // Mettre à jour la catégorie si elle est fournie
        if ($request->has('category')) {
            $note->category_id = $request->category; // Assurez-vous d'utiliser category_id
        }
    
        $note->save(); // Assurez-vous de sauvegarder les changements
    
        return Inertia::location('/notes');
    }


    public function create()
{
    $categories = Category::all(); // Récupérer toutes les catégories
    return Inertia::render('CreateNote', [
        'categories' => $categories,
    ]);
}


    public function destroy($id)
{
    $note = Note::findOrFail($id);
    $this->authorize('delete', $note);

    // Supprimer l'image associée si elle existe
    if ($note->image_path) {
        Storage::disk('public')->delete($note->image_path);
    }

    $note->delete();
    return Inertia::location('/notes');
}

public function edit($id)
{
    $note = Note::findOrFail($id);
    $categories = Category::all(); // Assurez-vous que cela fonctionne
    return Inertia::render('Edit', [
        'note' => $note,
        'categories' => $categories,
    ]);
}


    // Récupérer les catégories
    public function getCategories()
    {
        $categories = Category::all(); // Assurez-vous d'importer le modèle Category
        return response()->json($categories);
    }



    public function trash()
    {
        $deletedNotes = auth()->user()->notes()->onlyTrashed()->get();
    
        return Inertia::render('Trash', [
            'deletedNotes' => $deletedNotes,
        ]);
    }

public function restore($id)
{
    $note = Note::withTrashed()->find($id); // Récupère la note, même si elle est supprimée
    if ($note) {
        $note->restore(); // Restaure la note
    }
    
    return redirect()->route('notes.index')->with('success', 'Note restaurée avec succès !');
}

public function dashboard()
{
    $user = auth()->user();
    
    // Vérifiez si l'utilisateur est authentifié
    if (!$user) {
        return redirect()->route('login'); // Redirection si non authentifié
    }

    // Récupérer le total des notes
    $totalNotes = $user->notes()->count();
    $trashedNotesCount = $user->notes()->onlyTrashed()->count(); // Compter les notes dans la corbeille
    // Debug pour vérifier la valeur
    // dd($totalNotes); // Vérifiez cette ligne pour voir le nombre de notes

    return Inertia::render('Dashboard', [
        'totalNotes' => $totalNotes,
        'trashedNotesCount' => $trashedNotesCount, // Passer le nombre de notes dans la corbeille
       
    ]);
}

public function getTrashedNotesCount()
{
    return auth()->user()->notes()->onlyTrashed()->count();
}


public function forceDelete($id)
{
    $note = Note::onlyTrashed()->findOrFail($id); // Récupérer la note dans la corbeille
    $this->authorize('delete', $note); // Vérifier les autorisations

    // Supprimer l'image associée si elle existe
    if ($note->image_path) {
        Storage::disk('public')->delete($note->image_path);
    }

    $note->forceDelete(); // Suppression définitive
    return redirect()->route('notes.trash')->with('success', 'Note supprimée définitivement.');
}
}