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
//   return response()->json($contacts); 
  return ContactResource::collection($contacts);  
  }
// Retrieve all contacts with their associated groups

// Retrieve a single contact by ID with its associated groups
public function show($id)
{
    $contacts = Contacts::with('groups')->where('id', $id)->first();
    // return ContactResource::collection($contacts); 
    // $contact = Contact::with('groups')->findOrFail($id);
    return response()->json($contacts);
}

// Retrieve contacts grouped by their associated groups
public function groupedContacts()
{
    $contacts = Contacts::with('groups')->get();
    $grouped = [];

    foreach ($contacts as $contact) {
        foreach ($contact->groups as $group) {
            $grouped[$group->name][] = $contact;
        }
    }

    return response()->json($grouped);
}
 

    public function store(Request $request)
    {
        

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:contacts',
            'phone' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',

            'group_ids' => 'array',
            'group_ids.*' => 'exists:groups,id',
        ]);

        $contact = Contacts::create($validatedData);

        if (isset($validatedData['group_ids'])) {
            $contact->groups()->attach($validatedData['group_ids']);
        }

        return new ContactResource($contact->load('groups'));
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

       
        // $validatedData = $request->validate([
        //     'name' => 'sometimes|string|max:255',
        //     'email' => 'sometimes|string|email|max:255|unique:contacts,email,'.$id,
        //     'phone' => 'sometimes|string|max:15',
        //     'groups' => 'sometimes|array',
        //     'groups.*' => 'exists:groups,id'
        // ]);
    
        // $contact = Contact::findOrFail($id);
        $contact->update($validatedData);
    
        if (isset($validatedData['groups'])) {
            $contact->groups()->sync($validatedData['groups']);
        }
    
        return response()->json($contact);
        // return new ContactResource($contact->load('groups'));
    }

    public function destroy($id)
    {
        Contacts::where('id', $id)->first()->delete();
        return response()->json(null, 204);
        // $contact = Contact::findOrFail($id);
        // $contact->groups()->detach();
        // $contact->delete();

        // return response()->json(['message' => 'Contact deleted successfully']);
   
    }
    
}
