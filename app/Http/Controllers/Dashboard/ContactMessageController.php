<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('View Contact Message');

        $messages = ContactMessage::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . (string) $request->string('search')->trim() . '%';

                $query->where(function ($subQuery) use ($term) {
                    $subQuery
                        ->where('name', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('subject', 'like', $term);
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('dashboard.contact-messages.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage)
    {
        Gate::authorize('View Contact Message');

        return view('dashboard.contact-messages.show', compact('contactMessage'));
    }

    public function destroy(ContactMessage $contactMessage)
    {
        Gate::authorize('Delete Contact Message');

        $contactMessage->delete();

        return redirect()
            ->route('dashboard.contact-messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}
