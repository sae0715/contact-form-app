<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|integer|in:1,2,3',
            'email' => 'required|string|email|max:255',
            'tel' => 'required|string|regex:/^[0-9]{10,11}$/',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'detail' => 'required|string|max:120',
        ], [
            'first_name.required' => '姓を入力してください',
            'last_name.required' => '名を入力してください',
            'gender.required' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'tel.required' => '電話番号を入力してください',
            'address.required' => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.max:120' => 'お問い合わせ内容は120文字以内で入力してください',
        ]);

        $categories = Category::all();
        $category = Category::find($request->input('category_id'));
        $tags_ids = $request->input('tag_ids', []);
        $tags = Tag::whereIn('id', $tags_ids)->get();

        return view('contact.confirm', [
            'categories' => $categories,
            'validated' => $request->all(),
            'category' => $category,
            'tags' => $tags,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|integer|in:1,2,3',
            'email' => 'required|string|email|max:255',
            'tel' => 'required|string|regex:/^[0-9]{10,11}$/',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'detail' => 'required|string|max:120',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'integer|exists:tags,id',
        ]);

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
