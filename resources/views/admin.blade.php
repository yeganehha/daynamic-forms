<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href=" {{ asset('css/app.css') }} ">
    @livewireStyles
</head>
<body>
<livewire:form-maker :form="$form"></livewire:form-maker>
<script src=" {{asset('js/app.js')}} "></script>
@livewireScripts
</body>
</html>
