<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminBookController extends Controller
{
    // Admin Dashboard - lists all books
    public function dashboard()
    {
        $books = Book::latest()->get();

        return view('admin.dashboard', compact('books'));
    }

    // Form page to create a new book
    public function create()
    {
        return view('admin.create');
    }

    // Save new book to database (Store)
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        if (! empty($validated['category_name'])) {
            $categoryName = trim($validated['category_name']);
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Str::slug($categoryName)]
            );
            $validated['category_id'] = $category->id;
        } else {
            $validated['category_id'] = null;
        }

        Book::create($validated);

        return redirect('/admin/dashboard')->with('success', 'Book added successfully!');
    }

    // Form page to edit book details
    public function edit($id)
    {
        $book = Book::findOrFail($id);

        return view('admin.edit', compact('book'));
    }

    // Update modified details in database (Update)
    public function update(StoreBookRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        $validated = $request->validated();

        if (! empty($validated['category_name'])) {
            $categoryName = trim($validated['category_name']);
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Str::slug($categoryName)]
            );
            $validated['category_id'] = $category->id;
        } else {
            $validated['category_id'] = null;
        }

        $book->update($validated);

        return redirect('/admin/dashboard')->with('success', 'Book details updated successfully!');
    }

    // Delete a book from database (Delete)
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect('/admin/dashboard')->with('success', 'Book deleted successfully!');
    }
}
