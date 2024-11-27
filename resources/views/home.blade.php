<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <!-- Bootstrap 4 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .shortener-container {
            text-align: center;
            max-width: 1000px;
            margin: auto;
        }
        .shortener-container h1 {
            font-weight: bold;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <div class="shortener-container">
        <h1>Smart and powerful short links</h1>
        <p>Stay in control of your links with advanced features for shortening, targeting, and tracking.</p>
        <form method="POST" action="{{ route('shorten') }}">
            @csrf

            <div class="input-group mb-3">
                    <input
                        type="text"
                        name="original_url"
                        class="form-control urlInput @error('original_url') is-invalid @enderror"
                        placeholder="https://example.com"
                        value="{{ old('original_url') }}"
                    >
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Shorten</button>
                </div>
            </div>
            @error('original_url')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </form>


        @if (session()->has('shortUrl'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><h4 class="alert-heading">Well done!</h4></strong>
                <p>Your Short Link : <a href="{{ session()->get('shortUrl') }}" target="__blank">{{ session()->get('shortUrl') }}</a></p>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
