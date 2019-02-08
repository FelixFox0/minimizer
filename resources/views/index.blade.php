<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Minimizer</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <form method="post" action="{{ route('url.add') }}" >
                    @csrf
                    <input name="url" type="url" placeholder="enter your url" required>
                    <input type="submit" value="submit">
                </form>
            </div>
        </div>
    </body>
</html>
