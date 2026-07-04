<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sanggar Langlang Buana</title>

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

       <script type="module" src="http://localhost:5173/resources/js/app.js"></script>
       <script type="module" src="http://localhost:5173/resources/css/app.css"></script>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
                margin: 0;
                padding: 0;
            }
        </style>
    </head>
    <body class="antialiased">
        
        <div id="app">
            <home-page></home-page>
        </div>

    </body>
</html>