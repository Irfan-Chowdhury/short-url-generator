@extends('layouts.master')

@section('title', 'Home')

@push('css')
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .shortener-container {
            text-align: center;
            margin: auto;
        }

        .shortener-container h1 {
            font-weight: bold;
            margin-top: 70px;
        }

        .shortener-container p {
            color: #6c757d;
            margin-bottom: 30px;
        }

        .input-group input {
            border-radius: 30px 0 0 30px;
        }

        .input-group button {
            border-radius: 0 30px 30px 0;
        }

        .invalid-feedback {
            display: block;
            text-align: left;
        }

        .navbar {
            width: 100%;
            margin-bottom: 30px;
        }
    </style>
@endpush


@section('content')

    <div class="shortener-container mt-5 pt-5">
        <h1>Smart and Powerful Short Links</h1>
        <p>Stay in control of your links with advanced features for shortening, targeting, and tracking.</p>
        <form method="POST" action="{{ route('shorten') }}">
            @csrf
            <div class="input-group mb-3">
                <input type="url" name="original_url" class="form-control @error('original_url') is-invalid @enderror"
                    placeholder="https://example.com" value="{{ old('original_url') }}" required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Shorten</button>
                </div>
            </div>
            @error('original_url')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </form>

        @if (session()->has('shortUrl'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <h4 class="alert-heading">Well done!</h4>
                <p>Your Short Link:
                    <a href="{{ session()->get('shortUrl') }}" target="_blank">
                        {{ session()->get('shortUrl') }}
                    </a>
                </p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>

@endsection
