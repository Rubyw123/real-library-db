<head>
 	<title>Real Library</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style type="text/css">
        .brand{
            background: #cbb09c !important;
        }
        .brand-text{
            color: #cbb09c !important;
        }
        
        form{
            max-width: 1000px;
            margin: 5px auto;
            padding: 5px;
        }

        input[type = submit] {
            height: 30px;
            width: 100px;
        }

        input[type = button] {
            height: 30px;
            width: 100px;
        }

        input[type = text] {
            height: 30px; width: 80px;
            border:1px solid #000000 !important; margin-top:9px;
        }

        select {
            border:1px solid #000000; display:block; height:32px; width:150px; margin-top:1px;      
        }

        #link-container {
            text-align: center;
        }

        #link {
            display: inline-block;
            margin: 40px auto;
            padding: 20px;
        }
        
    </style>
 </head>

 <body class = "grey lighten-4">
    <nav class = "white z-depth-0">
        <div class="nav-wrapper">
            <a href="../index/index.php" class = "brand-logo center brand-text">
            Real, Edify and Learn</a>
            <ul id = "nav-mobile" class="right hide-on-small-and-down">
                <li><a href="../profile/my_profile.php" class = "btn brand z-depth-0">
                    My profile
                </a></li>
            </ul>

            <ul id = "nav-mobile" class = "left hide-on-med-and-down">
                <li><a href="../event/event.php" class = "brand-text">Events</a></li>
                <li><a href="../rental/rent.php" class = "brand-text">Books</a></li>
                <li><a href="../studyroom/studyroom.php" class = "brand-text">Study Rooms</a></li>
            </ul>
        </div>
    </nav>
