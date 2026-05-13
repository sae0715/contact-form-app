<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
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

    public function confirm(Request $request)
    {
        $categories = Category::all();
        $category = Category::find($request->input('category_id'));

        return view('contact.confirm', [
            'categories' => $categories,
            'validated' => $request->all(),
            'category' => $category,
        ]);
    }

    public function thanks()
    {
        return view('contact.thanks');
    }
}
