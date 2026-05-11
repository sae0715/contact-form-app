<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('contact.index', ['categories' => $categories]);
    }

    public function confirm(Request $request)
    {
        $categories = Category::all();
        return view('contact.confirm', $request->all());
    }

    public function thanks()
    {
        return view('contact.thanks');
    }
}
