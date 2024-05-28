<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
 // Retrieve all contacts with related groups
 $contacts = Contacts::with('groups')->get();

 return ContactResource::collection($contacts);    }

    public function store(Request $request)
    {
        

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:contacts',
            'phone' => 'nullable|string|max:255',
            'group_ids' => 'array',
            'group_ids.*' => 'exists:groups,id',
        ]);

        $contact = Contacts::create($validatedData);

        if (isset($validatedData['group_ids'])) {
            $contact->groups()->attach($validatedData['group_ids']);
        }

        return new ContactResource($contact->load('groups'));
    }

    public function show($id)
    {
        $contacts = Contacts::with('groups')->where('id', $id)->first();
        return ContactResource::collection($contacts); 
    }

    public function update(Request $request, Contacts $contact)
    {
               $validatedData = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:contacts,email,' . $contact->id,
            'phone' => 'nullable|string|max:255',
            'group_ids' => 'array',
            'group_ids.*' => 'exists:groups,id',
        ]);

        $contact->update($validatedData);

        if (isset($validatedData['group_ids'])) {
            $contact->groups()->sync($validatedData['group_ids']);
        }

        return new ContactResource($contact->load('groups'));
    }

    public function destroy($id)
    {
        Contacts::where('id', $id)->first()->delete();
        return response()->json(null, 204);
    }
}
