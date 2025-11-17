<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactStoreRequest;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function store(ContactStoreRequest $request)
    {
        ContactMessage::create($request->validated());

        return redirect()
            ->back()
            ->with('success', 'Your message has been submitted. We will reach you soon.');
    }
}
