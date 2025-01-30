<?php

// app/Http/Controllers/Dashboard/AgencyUserController.php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AgencyUser;
use Illuminate\Http\Request;

class AgencyUserController extends Controller
{

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|string',
            'status' => 'required|in:pending,active,inactive',
        ]);

        AgencyUser::create($validatedData);

        return redirect()->back()->with('success', 'Agency User created successfully.');
    }

    public function update(Request $request, AgencyUser $agencyUser)
    {
        $validatedData = $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|string',
            'status' => 'required|in:pending,active,inactive',
        ]);

        $agencyUser->update($validatedData);

        return redirect()->back()->with('success', 'Agency User updated successfully.');
    }

    public function destroy(AgencyUser $agencyUser)
    {
        $agencyUser->delete();
        return redirect()->back()->with('success', 'Agency User deleted successfully.');
    }
}
