<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;

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
    // Directly get validated data
    $validated = $request->validated();

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
    
    // Use the same validation rule when editing
    $validated = $request->validated();

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