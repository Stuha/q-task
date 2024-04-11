<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\AuthorServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthorController extends Controller
{
    public function __construct(private readonly AuthorServiceInterface $authorService)
    {
        $this->middleware('auth.session');
    }

    public function index(Request $request): View|RedirectResponse
    {
        $page = $request->query('page') ?? 1;
        $authorsData = $this->authorService->getAuthorsDataByPage($page);

        if (is_array($authorsData)) {
            return redirect()->route('dashboard')->withErrors($authorsData);
        }

        $authors = $this->authorService->getAuthors($authorsData->items);
        $totalPages = $authorsData->total_pages;
        $currentPage = $authorsData->current_page;

        return view('authors', compact('authors', 'totalPages', 'currentPage'));
    }

    public function show(Request $request): View|RedirectResponse
    {
        $author = $this->authorService->getAuthor($request->route('id'));

        if (is_array($author)) {
            return redirect()->route('dashboard')->withErrors($author);
        }

        return view('author', compact('author'));
    }

    public function delete(Request $request): RedirectResponse
    {
        $response = $this->authorService->deleteAuthor($request->route('id'));

        if (is_array($response)) {
            return redirect()->route('author.show', $request->route('id'))->withErrors($response);
        }

        return redirect()->route('authors.index');
    }
}
