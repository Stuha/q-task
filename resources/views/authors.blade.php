
@extends('layouts.app')

@section('title', 'Authors')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2>Authors</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date of Birth</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($authors as $author)
                        <tr>
                            <td>
                                <a href="{{ route('author.show', $author['id']) }}">{{ $author['name'] }}</a>
                            </td>
                            <td>
                                {{ $author['birthday'] }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    <button class="btn btn-secondary" @if($currentPage <= 1) disabled @endif
                        onclick="window.location.href='{{ route('authors.index', ['page' => $currentPage - 1]) }}'">Previous
                    </button>
                    <span>Page {{ $currentPage }} of {{ $totalPages }}</span>
                    <button class="btn btn-secondary" @if($currentPage >= $totalPages) disabled @endif
                        onclick="window.location.href='{{ route('authors.index', ['page' => $currentPage + 1]) }}'">Next
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
