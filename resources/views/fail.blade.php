<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            display: grid;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #e44d26;
            text-align: center;
            margin: 0;
            margin-top: 10px;
        }

        h2 {
            text-align: center;
            margin: 0;
            color: #333;
            margin-top: 10px;
        }

        p {
            margin-top: 10px;
            color: #004AAD;
            font-size: large;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Halo <b>{{ $content['user'] }}</b>, order anda dihapus karena : </p>
        <h2>{{ $content['body'] }}</h2>
        <h2 style="color:#e44d26">Status : {{ $content['status']}}</h2>
    </div>
</body>
</html>
