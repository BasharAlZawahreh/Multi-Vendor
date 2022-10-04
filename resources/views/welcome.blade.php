<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cities</title>
</head>

<body>
    <h1>Cities</h1>
    <select>
        @foreach ($cities as $city)
            <option value="{{ $city->value }}">{{ "$city->name_en" }}</option>
        @endforeach
    </select>
</body>

</html>
