<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakeryza</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f8f1e4;
        }
        .banner {
            width: 90%;
            max-width: 1200px;
            background: #FFF;
            text-align: center;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-image: url('{{ asset('images/wa.jpg') }}');
        }
        .title {
            background-color: #6D4C41;
            font-size: 60px;
            font-weight: bold;
            color: rgb(237, 227, 224);
            padding: 10px;
            border-radius: 10px;
        }
        .subtitle {
            font-size: 30px;
            color: #A0522D;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .contact {
            font-size: 18px;
            color: #FFF;
            background-color: #6D4C41;
            border-radius: 50px;
            display: inline-block;
            padding: 10px;
            margin: 10px;
        }
        .contact a {
            color: white;
            text-decoration: none;
        }
        .contact a:hover {
            color: pink;
        }
        .info {
            font-size: 18px;
            color: #6D4C41;
            margin-top: 20px;
        }
        .price {
            background: #6D4C41;
            color: #FFF;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 22px;
            margin-top: 20px;
            display: inline-block;
            border: 0px solid white;
        }
        .buttons {
            margin-top: 20px;
        }
        .buttons a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 10px;
            display: inline-block;
            margin: 5px;
        }
        .login {
            background-color: #A0522D;
        }
        .register {
            background-color: #8B4513;
        }
        footer {
            margin: 1em 0;
            padding: 1em;
            background-color: #6D4C41;
        }
    </style>
</head>
<body>
    <div class="banner">
        <h1 class="title">Welcome to Bakeryza</h1>
        <div class="gambar">
            <img src="{{ asset('images/pp.jpg') }}" width="500" height="255" alt="Bakery Items">
        </div>
        <p class="subtitle">Freshly Baked, Straight to Your Heart!</p>

        <div class="buttons">
            <a href="{{ route('login') }}" class="login">Login</a>
            <a href="{{ route('register') }}" class="register">Register</a>
        </div>

        <footer>
            <div class="contact">
                <a href="https://wa.me/qr/3PEW6CEOX2YEL1">📞 Delivery: 0858-5538-6043</a> | 🏠 Balen, Bojonegoro - Jawa Timur
            </div>
        </footer>
    </div>
</body>
</html>
