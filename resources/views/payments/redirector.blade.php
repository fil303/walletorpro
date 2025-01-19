<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ _t("Redirecting") }}</title>
</head>

<body>
<form action="{{ $action ?? '/' }}" method="{{ $method ?? 'GET' }}">
    @foreach($inputs ?? [] as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}"/>
    @endforeach
</form>
<script>
	"use strict"; document.querySelector('form').submit();
</script>
</body>
</html>

