<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scripting Tools</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fff;
            color: #333;
        }

        /* Navbar */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            background: linear-gradient(to right, #fff, #f8e7fc);
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            color: #1a2b49;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 25px;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: 0.3s;
        }

        nav ul li a:hover {
            color: #007bff;
        }

        .login-btn {
            padding: 8px 18px;
            border-radius: 25px;
            background: linear-gradient(to right, #3a7bd5, #00d2ff);
            color: #fff !important;
            font-weight: bold;
        }

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 90vh;
            padding: 0 8%;
            background: #fff;
        }

        .hero-text {
            max-width: 500px;
        }

        .hero-text h1 {
            font-size: 48px;
            color: #007bff;
            margin-bottom: 20px;
        }

        .hero-text p {
            font-size: 18px;
            line-height: 1.6;
            color: #444;
            margin-bottom: 30px;
        }

        .hero-text .btn {
            padding: 12px 28px;
            border-radius: 30px;
            background: linear-gradient(to right, #3a7bd5, #00d2ff);
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            font-weight: bold;
        }

        .hero-image {
            flex: 1;
            text-align: right;
        }

        .hero-image img {
            max-width: 500px;
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">Scripting Tools</div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="{{ url('/login') }}" class="login-btn">Login</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-text">
            <h1>Welcome to Scripting Tools</h1>
            <p>Boost your productivity with our powerful scripting solutions. Automate tasks, improve efficiency, and
                save valuable time with tools crafted for developers and businesses.</p>
            <a href="#" class="btn">Get Started</a>
        </div>
        <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=1000" alt="Colorful background">
        </div>
    </section>
</body>

</html>
