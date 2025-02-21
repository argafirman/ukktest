<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Felia Bakery</title>
    <style>
        body {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            text-align: center;
            background-color: #fff4e6;
            margin: 0;
            padding: 0;
            position: relative;
            width: 100%;
            display: flex;
            flex-direction: column;
            background-image: url('{{ asset('images/bg2.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden;
        }
        .container {
            background-color: rgb(71, 46, 20);
            padding: 40px 10px;
            flex-grow: 1;
        }
        .title {
            font-size: 55px;
            font-weight: bold;
            color: rgb(247, 213, 189);
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.2);
        }
        .subtitle {
            font-size: 28px;
            color: rgb(233, 181, 143);
            font-style: italic;
        }
        .banner {
            text-align: center;
            height: 62vh;
            display: flex;
        }
        .banner .image {
            flex: -30;
            display: flex;
            align-items: center;
        }
        .banner-text {
            width: 40%;
            font-size: 20px;
            color: rgb(53, 26, 6);
            text-align: left;
            margin-top: 50px;
        }
        .footer {
            background-color: #3a2612;
            color: white;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
            border-radius: 15px;
            display: block;
            width: 100%;
            text-align: center;
            position: relative;
        }
        marquee {
            font-size: 16px;
            font-weight: bold;
            display: block;
        }
        .corner-decoration {
            position: absolute;
            padding: 20px;
            width: 160px;
            height: 160px;
        }
        .top-right {
            top: 2px;
            right: 2px;
        }
        .nav {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 15px;
        }
        .nav a {
            color: #3a2612;
            font-weight: bold;
            text-decoration: none;
            font-size: 18px;
            background: #f3d9b1;
            padding: 8px 12px;
            border-radius: 5px;
        }
        .nav a:hover {
            background: #e4b97f;
        }
    </style>
</head>
<body>
    <img src="{{ asset('images/gandum1.png') }}" class="corner-decoration top-right" alt="Leaf Decor">
    <div class="nav">
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Registrasi</a>
    </div>
    <div class="container">
        <div class="title">Selamat Datang di Felia Bakery</div>
        <div class="subtitle">Rasa dan Kualitas Terbaik!</div>
    </div>
    <div class="banner">
        <div class="image">
            <img src="{{ asset('images/chef1.png') }}" alt="">
        </div> 
        <div class="banner-text">
            <h2>Hidangan berkualitas tinggi dengan harga terjangkau!</h2>
            <div class="teks">
                <p>Lagi bad mood? Yuk Mampir ke Felia Bakery!!</p>
                <p>Disini tersedia beberapa macam roti yang rasanya 100% mantap dan nikmat.</p>
                <p>Ampuh atasi bad mood! Ubah bad mood jadi good mood di Felia Bakery.</p>
            </div>
        </div>
    </div>
    <div class="footer">
        <marquee> ☎️ 088296190618 | 📍 Sumberrejo, Bojonegoro, Jawa Timur | 🚗 Kunjungi Toko Roti Felia Bakery!!</marquee>
    </div>
</body>
</html>
