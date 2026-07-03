<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Shows and searches all books (Listing & Search)
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('author', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $books = $query->latest()->get();
        $categories = Category::whereHas('books')->get();

        return view('books.index', compact('books', 'categories'));
    }

    // Displays details of a specific book (Details View)
    public function show($id)
    {
        // Shows 404 error if book does not exist
        $book = Book::with('category')->findOrFail($id);

        return view('books.show', compact('book'));
    }
}
