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
        $query = \App\Models\User::where('role', 'member');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
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
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'nullable|string|min:8',
            'telephone' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:255',
            'competences' => 'nullable|string',
            'statut' => 'boolean',
            'date_naissance' => 'nullable|date',
            'adresse' => 'nullable|string',
        ]);

        $createData = $validated;
        $createData['role'] = 'member';

        // Members might not have a password set directly through this API, provide a dummy one or handle it based on business rules
        if (!isset($createData['password'])) {
            $createData['password'] = \Illuminate\Support\Facades\Hash::make('password'); // Default password for member created by admin
        } else {
            $createData['password'] = \Illuminate\Support\Facades\Hash::make($createData['password']);
        }

        $member = \App\Models\User::create($createData);

        return response()->json($member, 201);
    }

    public function show(string $id)
    {
        $member = \App\Models\User::where('role', 'member')->findOrFail($id);
        return response()->json($member);
    }

    public function update(Request $request, string $id)
    {
        $member = \App\Models\User::where('role', 'member')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $member->id,
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
        $member = \App\Models\User::where('role', 'member')->findOrFail($id);
        $member->delete();

        return response()->json(null, 204);
    }
}
