<!DOCTYPE html>
<html>

<head>
    <title>SIREMINDER Password Reset</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet" />
</head>

<body
    style="
            font-family: 'Roboto', Arial, Helvetica, sans-serif;
            background-color: #f1f5f9;
            padding: 20px;
        ">
    <h1 style="margin-bottom: 30px">
        <a href="{{ env('APP_URL') }}" style="text-decoration: none">
            <span style="color: #000865">SI</span><span style="color: #6571ff; font-weight: 300">REMINDER</span>
        </a>
    </h1>

    <div
        style="
                border: 1px solid rgb(220, 220, 220);
                border-radius: 5px;
                background: white;
                padding: 40px;
                color: #111827;
            ">
        <h2 style="margin: 0 0 30px 0; font-weight: 300; font-size: 1.3em">
            Halo {{ $username }},
        </h2>

        <p style="font-weight: 700">
            Tekan link berikut untuk mereset password Anda.
        </p>

        <a style="
                    display: block;
                    text-align: center;
                    width: 120px;
                    margin: 30px auto;
                    text-decoration: none;
                    color: white;
                    background: #6571ff;
                    padding: 10px 20px;
                    border-radius: 2px;
                "
            href="{{ $url }}">Reset Password</a>

        <p style="margin-bottom: 10px">
            Atau akses pada link berikut: <br>
            <a href="{{ $url }}">{{ $url }}</a>
        </p>
        <p style="margin-bottom: 40px">
            Link akan kadaluarsa 24 jam setelah email ini diterima. Jika Anda tidak merasa melakukan reset password,
            abaikan email ini.
        </p>

        <div style="font-size: 0.9em; margin-bottom: 3px">Salam,</div>
        <div style="font-size: 0.9em">SIREMINDER</div>
    </div>

    <div
        style="
                margin-top: 10px;
                text-align: center;
                font-size: 0.8em;
                color: rgb(181, 181, 181);
            ">
        SIREMINDER
    </div>
</body>

</html>
