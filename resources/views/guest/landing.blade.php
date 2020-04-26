<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>ESM - Directory</title>

    <style>
        .landing-cover {
            background-image: url('images/screenshots/main_image.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 830px;
            position: relative;
        }

        .landing-cover-text {
            padding-top: 150px;
            height: 500px;
            width: 100%;
            font-family: Didot,garamond;
            font-size: 50px;
            color: #fff;
        }

        .landing-cover a {
            background-color: #fff;
            border-color: #fff;
            color: #2b2b2b;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="shadow">
        <nav id="top" class="navbar navbar-expand-lg navbar-light container">
            <a class="navbar-brand navbar-logo full-logo" href="/">ESM - Directory</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbarNavDropdown" class="collapse navbar-collapse align-content-center justify-content-end p-3">
                <ul class="navbar-nav pt-1">
                    <li>
                        <a class="nav-link scroll" href="#home">HOME <span class="sr-only">(current)</span></a>
                    </li>
                    <li>
                        <a class="nav-link scroll" href="/directory">DIRECTORY</a>
                    </li>
                    <li>
                        <a class="nav-link" href="/login">LOGIN</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div id="home" class="landing-cover">
        <div class="text-center landing-cover-text">
            <h1 class="cover-text">Looking for a photographer?<br>
            Let us help you find that perfect photographer!</h1>
            <div class="row col-md-12 justify-content-center mt-5">
            <div class="col-lg-3 col-md-4 col-sm-6 pb-3">
                <a href="/directory" class="btn btn-block btn-light shadow">START SEARCH</a>
            </div>
            </div>
        </div>
    </div>
</body>
</html>