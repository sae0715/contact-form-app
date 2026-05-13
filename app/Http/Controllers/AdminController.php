<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Tag;

class AdminController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $contacts = Contact::paginate(7);
        $tags = Tag::all();

        return view('admin.index', [
            'categories' => $categories,
            'contacts' => $contacts,
            'tags' => $tags,
        ]);
    }
}
