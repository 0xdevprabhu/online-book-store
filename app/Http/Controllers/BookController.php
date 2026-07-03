<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Shows and searches all books (Listing & Search)
    public function index(Request $request)
    {
        $query = Book::query();

        // If the user has typed anything in the search box
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('author', 'LIKE', "%{$searchTerm}%");
        }

        // Displays recently added books first
        $books = $query->latest()->get();

        return view('books.index', compact('books'));
    }

    // Displays details of a specific book (Details View)
    public function show($id)
    {
        // Shows 404 error if book does not exist
        $book = Book::with('category')->findOrFail($id);
        
        return view('books.show', compact('book'));
    }
}