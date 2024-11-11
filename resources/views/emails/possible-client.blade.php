<!DOCTYPE html>
<html>
<head>
    <title>Posibil client</title>
</head>
<body>
    <h1>{{ $data['subject'] }}</h1>

    <p>{{ $data['name'] }} : {{ $data['phone'] }}</p>
    <p>Email : {{ $data['email'] }}</p>

    <p>{{ $data['message'] }}</p>
</body>
</html>
