<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = \App\Models\Membre::where('role', 'member');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('ville', 'like', "%{$search}%")
                    ->orWhere('competences', 'like', "%{$search}%");
            });
        }

        if ($request->filled('statut')) {
            $statut = filter_var($request->statut, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($statut !== null) {
                $query->where('statut', $statut);
            }
        }

        $members = $query->latest()->paginate(10);

        return response()->json($members);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:membres',
            'telephone' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:255',
            'competences' => 'nullable|string',
            'statut' => 'boolean',
            'date_naissance' => 'nullable|date',
            'adresse' => 'nullable|string',
        ]);

        $member = \App\Models\Membre::create($validated);

        return response()->json($member, 201);
    }

    public function show(string $id)
    {
        $member = \App\Models\Membre::findOrFail($id);
        return response()->json($member);
    }

    public function update(Request $request, string $id)
    {
        $member = \App\Models\Membre::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:membres,email,' . $member->id,
            'telephone' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:255',
            'competences' => 'nullable|string',
            'statut' => 'boolean',
            'date_naissance' => 'nullable|date',
            'adresse' => 'nullable|string',
        ]);

        $member->update($validated);

        return response()->json($member);
    }

    public function destroy(string $id)
    {
        $member = \App\Models\Membre::findOrFail($id);
        $member->delete();

        return response()->json(null, 204);
    }
}
