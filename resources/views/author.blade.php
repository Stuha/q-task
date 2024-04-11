
@extends('layouts.app')

@section('title', 'Author Details')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2>Author Details</h2>
                <div class="card">
                    <div class="card-header">
                        Author Information
                    </div>
                    <div class="card-body">
                        <p><strong>First Name:</strong> {{ $author->first_name }}</p>
                        <p><strong>Last Name:</strong> {{ $author->last_name }}</p>
                        <p><strong>Place of Birth:</strong> {{ $author->place_of_birth }}</p>
                        <h5>Related Books</h5>
                        @if (count($author->books) > 0)
                            <ul class="list-group">
                                @foreach ($author->books as $book)
                                    <li class="list-group-item">
                                        {{ $book->title }}
                                        <form action="{{ route('book.delete', [$book->id, $author->id]) }}" method="POST" class="float-right">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No related books</p>
                        @endif
                    </div>
                    @if (count($author->books) == 0)
                        <div class="card-footer">
                            <form action="{{ route('author.delete', $author->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Author</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @error('error')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @endif
    </div>
@endsection
