<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Afficher liste des messages
     */
    public function index(Request $request)
    {
        $this->authorize('view_contacts');
        $query = Contact::query();

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filtrage par statut lu/non lu
        if ($request->has('lu')) {
            $query->where('lu', $request->lu);
        }

        // Tri
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $contacts = $query->paginate(20);

        // Statistiques
        $stats = [
            'total' => Contact::count(),
            'non_lus' => Contact::where('lu', false)->count(),
            'lus' => Contact::where('lu', true)->count(),
        ];

        return Inertia::render('Admin/Contacts/Index', [
            'contacts' => $contacts,
            'stats' => $stats,
            'filters' => $request->only(['search', 'lu', 'sort', 'direction']),
        ]);
    }

    /**
     * Afficher un message
     */
    public function show(Contact $contact)
    {
        $this->authorize('view_contacts');
        // Marquer comme lu automatiquement
        if (!$contact->lu) {
            $contact->update(['lu' => true]);

            activity()
                ->performedOn($contact)
                ->causedBy(auth()->user())
                ->log("Message lu : #{$contact->id}");
        }

        return Inertia::render('Admin/Contacts/Show', [
            'contact' => $contact,
        ]);
    }

    /**
     * Marquer comme lu/non lu
     */
    public function toggleLu(Contact $contact)
    {
        $this->authorize('manage_contacts');

        $contact->update(['lu' => !$contact->lu]);

        $action = $contact->lu ? 'lu' : 'non lu';

        activity()
            ->performedOn($contact)
            ->causedBy(auth()->user())
            ->log("Message marqué comme {$action} : #{$contact->id}");

        return back()->with('success', "Message marqué comme {$action}");
    }

    /**
     * Supprimer un message
     */
    public function destroy(Contact $contact)
    {
        $this->authorize('manage_contacts');

        $contact->delete();

        activity()
            ->performedOn($contact)
            ->causedBy(auth()->user())
            ->log("Message supprimé : #{$contact->id}");

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message supprimé avec succès');
    }

    /**
     * Répondre à un message (envoyer email)
     */
    public function reply(Request $request, Contact $contact)
    {
        $this->authorize('manage_contacts');

        $validated = $request->validate([
            'reponse' => 'required|string|min:10',
        ], [
            'reponse.required' => 'La réponse est obligatoire',
            'reponse.min' => 'La réponse doit contenir au moins 10 caractères',
        ]);

        // TODO: Envoyer email de réponse au contact
        // Mail::to($contact->email)->send(new ContactReplyMail($validated['reponse']));

        // Marquer comme lu
        $contact->update(['lu' => true]);

        activity()
            ->performedOn($contact)
            ->causedBy(auth()->user())
            ->log("Réponse envoyée au message : #{$contact->id}");

        return back()->with('success', 'Réponse envoyée avec succès');
    }
}
