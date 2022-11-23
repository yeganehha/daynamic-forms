<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href=" {{ mix('css/app.css') }} ">
    @livewireStyles
</head>
<body>
<livewire:form-maker :form="$form"></livewire:form-maker>
@livewireScripts
<script src=" {{mix('js/app.js')}} "></script>
</body>
</html>
