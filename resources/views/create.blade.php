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
                <a href="//{{$_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_ORIGINAL_HOST']??$_SERVER['HTTP_HOST']}}/{{$url}}" target="_blank">
                    {{$_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_ORIGINAL_HOST']??$_SERVER['HTTP_HOST']}}/{{$url}}
                </a>
            </div>
        </div>
    </body>
</html>
