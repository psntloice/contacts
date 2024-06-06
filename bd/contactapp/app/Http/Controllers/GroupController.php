<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use App\Http\Resources\GroupResource;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $contacts = Groups::with('contacts')->get();
//   return response()->json($contacts); 
        return GroupResource::collection(Groups::with('contacts')->get());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'group_name' => 'required|string|max:255|unique:groups,group_name',
            'description' => 'nullable|string',
            'contact_ids' => 'array',
            'contact_ids.*' => 'exists:contacts,id',
        ]);

        $group = Groups::create($validatedData);

        if (isset($validatedData['contact_ids'])) {
            $group->contacts()->attach($validatedData['contact_ids']);
        }

        return new GroupResource($group->load('contacts'));
    }

    public function show(Groups $group)
    {
        return new GroupResource($group->load('contacts'));
    }

    public function update(Request $request, Groups $group)
    {
        $validatedData = $request->validate([
            'group_name' => 'sometimes|required|string|max:255|unique:groups,group_name,' . $group->id,
            'description' => 'nullable|string',
            'contact_ids' => 'array',
            'contact_ids.*' => 'exists:contacts,id',
        ]);

        $group->update($validatedData);

        if (isset($validatedData['contact_ids'])) {
            $group->contacts()->sync($validatedData['contact_ids']);
        }

        return new GroupResource($group->load('contacts'));
    }

    public function destroy(Groups $group)
    {
        $group->delete();

        return response()->noContent();
    }

    public function addContacts(Request $request, Groups $group)
    {
        $validatedData = $request->validate([
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id',
        ]);

        $group->contacts()->attach($validatedData['contact_ids']);

        return new GroupResource($group->load('contacts'));
    }

    public function removeContacts(Request $request, Groups $group)
    {
        $validatedData = $request->validate([
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id',
        ]);

        $group->contacts()->detach($validatedData['contact_ids']);

        return new GroupResource($group->load('contacts'));
    }
}
