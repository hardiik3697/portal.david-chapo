<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>=
</head>
<body>
    @if(isset($pageJs) && is_array($pageJs))
        @foreach ($pageJs as $jsFile)
            @vite($jsFile)
        @endforeach
    @endif
</body>
</html>
