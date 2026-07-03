<?php

use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can store book with category name', function () {
    $this->withSession(['admin_logged_in' => true]);

    $response = $this->post('/admin/books', [
        'title' => 'The Pragmatic Programmer',
        'author' => 'Andy Hunt',
        'price' => 1200.00,
        'is_available' => 1,
        'description' => 'A guide for software developers.',
        'category_name' => 'Software Engineering',
    ]);

    $response->assertRedirect('/admin/dashboard');

    $this->assertDatabaseHas('categories', [
        'name' => 'Software Engineering',
    ]);

    $category = Category::where('name', 'Software Engineering')->first();
    $this->assertNotNull($category);

    $this->assertDatabaseHas('books', [
        'title' => 'The Pragmatic Programmer',
        'category_id' => $category->id,
    ]);
});

test('admin can update book category name', function () {
    $this->withSession(['admin_logged_in' => true]);

    $category = Category::create([
        'name' => 'Original Category',
        'slug' => 'original-category',
    ]);

    $book = Book::create([
        'title' => 'Original Book',
        'author' => 'Author',
        'price' => 500.00,
        'is_available' => 1,
        'category_id' => $category->id,
    ]);

    $response = $this->put('/admin/books/'.$book->id, [
        'title' => 'Original Book',
        'author' => 'Author',
        'price' => 500.00,
        'is_available' => 1,
        'category_name' => 'Updated Category',
    ]);

    $response->assertRedirect('/admin/dashboard');

    $this->assertDatabaseHas('categories', [
        'name' => 'Updated Category',
    ]);

    $newCategory = Category::where('name', 'Updated Category')->first();
    $this->assertNotNull($newCategory);

    $this->assertDatabaseHas('books', [
        'id' => $book->id,
        'category_id' => $newCategory->id,
    ]);
});

test('public gallery can filter by category', function () {
    $category1 = Category::create(['name' => 'Fiction', 'slug' => 'fiction']);
    $category2 = Category::create(['name' => 'Science', 'slug' => 'science']);

    $book1 = Book::create([
        'title' => 'Fiction Novel',
        'author' => 'Author A',
        'price' => 200,
        'is_available' => 1,
        'category_id' => $category1->id,
    ]);

    $book2 = Book::create([
        'title' => 'Science Book',
        'author' => 'Author B',
        'price' => 300,
        'is_available' => 1,
        'category_id' => $category2->id,
    ]);

    $response = $this->get('/books?category='.$category1->id);

    $response->assertStatus(200);
    $response->assertSee('Fiction Novel');
    $response->assertDontSee('Science Book');
});
