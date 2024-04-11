<!-- resources/views/books/create.blade.php -->

@extends('layouts.app')

@section('title', 'Create Book')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2>Create Book</h2>
                <form action="{{ route('book.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="author">Author</label>
                        <select class="form-control" id="author" name="author_id">
                            @foreach ($authors as $author)
                                <option value="{{ $author['id'] }}">{{ $author['name']}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="release_date">Release Date</label>
                        <input type="date" class="form-control" id="release_date" name="release_date" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="isbn">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="isbn" required>
                    </div>
                    <div class="form-group">
                        <label for="format">Format</label>
                        <input type="text" class="form-control" id="format" name="format" required>
                    </div>
                    <div class="form-group">
                        <label for="number_of_pages">Number of Pages</label>
                        <input type="number" class="form-control" id="number_of_pages" name="number_of_pages" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Book</button>
                </form>
            </div>
            @error('error')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
            @endif
        </div>
    </div>
@endsection

