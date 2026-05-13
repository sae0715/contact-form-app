<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('contact.index', [
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function confirm(StoreContactRequest $request)
    {
        $categories = Category::all();
        $category = Category::find($request->input('category_id'));
        $tag_ids = $request->input('tag_ids', []);
        $tags = Tag::whereIn('id', $tag_ids)->get();

        return view('contact.confirm', [
            'categories' => $categories,
            'validated' => $request->all(),
            'category' => $category,
            'tags' => $tags,
        ]);
    }

    public function store(StoreContactRequest $request)
    {
        $validated = $request->validated();

        $contact = Contact::create($validated);

        $tag_ids = $request->input('tag_ids', []);
        if (!empty($tag_ids)) {
            foreach ($tag_ids as $tag_id) {
                $contact->tags()->attach($tag_id, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect('/thanks');
    }

    public function thanks()
    {
        return view('contact.thanks');
    }
}
