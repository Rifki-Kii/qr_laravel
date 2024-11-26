<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ID Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            font-size: 68pt;
            margin-bottom: 20px;
        }
        .qr-container {
            text-align: center;
            margin-top: 20px;
        }
        table {
            margin-top: 60px;
            width: 100%;
            font-size: 15pt;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
        }
        td:first-child {
            width: 20%;
        }
        td:nth-child(2) {
            width: 20%;
        }
        td:last-child {
            width: 60%;
        }
    </style>
</head>

<body>
    <h1>Meet AP</h1>
    <div class="qr-container">
        <!-- Tampilkan QR code -->
        <img src="data:image/png;base64,{{ $qr_code }}" alt="" width="150px">
    </div>

    <table>
        <tr>
            <td></td>
            <td>Nama</td>
            <td>{{ $participant->name }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Email</td>
            <td>{{ $participant->email }}</td>
        </tr>
        <tr>
            <td></td>
            <td>No Hp</td>
            <td>{{ $participant->phone }}</td>
        </tr>
    </table>
</body>
</html>
