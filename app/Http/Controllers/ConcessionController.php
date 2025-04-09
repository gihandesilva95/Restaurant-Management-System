<?php

namespace App\Http\Controllers;

use App\Models\Concession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ConcessionController extends Controller
{
    public function index()
    {
        $concessions = Concession::where('status', 'Active')->latest()->paginate(5);
          
        return view('concessions.index', compact('concessions'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        return view('concessions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'image' => 'required|image',
            'price' => 'required|numeric|min:0',
        ]);

        $imagePath = $request->file('image')->store('concessions', 'public');

        $concession = Concession::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => basename($imagePath),
            'price' => $validated['price'],
        ]);

        return redirect()->route('concessions.index')->with('success', 'Concession added successfully.');
    }

    public function show($id)
    {
        return Concession::findOrFail($id);
    }

    public function edit(Concession $concession)
    {
        return view('concessions.edit',compact('concession'));
    }

    public function update(Request $request, Concession $concession)
    {
        // Validate the data
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
        ]);

        // Check if a new image was uploaded
        if ($request->hasFile('image')) {
            // Delete old image from storage if it exists
            if ($concession->image) {
                Storage::disk('public')->delete($concession->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('concessions', 'public');
            $validated['image'] = basename($imagePath);
        }

        // Update the concession with the validated data
        $concession->update($validated);

        return redirect()->route('concessions.index')->with('success', 'Concession Updated successfully.');
    }



    public function destroy(Concession $concession)
    {
        if ($concession->status === 'Active') {
            $concession->status = 'In-Active';
            $concession->save();
    
            return redirect()->route('concessions.index')->with('success', 'Concession deleted successfully.');
    
        } else{
            return redirect()->route('concessions.index')->with('error', 'Concession cannot be delete.');
        }
    
    
        return redirect()->route('concessions.index')->with('error', 'Concession cannot be delete.');
    }
    

}

