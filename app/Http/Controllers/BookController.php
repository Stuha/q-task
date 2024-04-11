<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Services\Interfaces\AuthorServiceInterface;
use App\Services\Interfaces\BookServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    public function __construct(
        private readonly BookServiceInterface $bookService,
        private readonly AuthorServiceInterface $authorService
    )
    {
        $this->middleware('auth.session');
    }

    public function create(): View|RedirectResponse
    {
        $authorsData = $this->authorService->getAllAuthors();

        if (array_key_exists('error', $authorsData)) {
            return redirect()->route('dashboard')->withErrors($authorsData);
        }

        $authors = $this->authorService->getAuthors($authorsData);

        return view('create_book', compact('authors'));
    }

    public function store(StoreBookRequest $request): RedirectResponse
    {
        $response = $this->bookService->createBook($request->validated());

        if (is_array($response)) {
            return redirect()->route('book.store')->withErrors($response);
        }

        return redirect()->route('authors.index');
    }

    public function delete(Request $request): RedirectResponse
    {
        $response = $this->bookService->deleteBook($request->route('id'));

        if (is_array($response)) {
            return redirect()->route('author.show', $request->route('author_id'))->withErrors($response);
        }

        return redirect()->route('author.show', $request->route('author_id'));
    }
}
