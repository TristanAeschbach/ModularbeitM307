<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesheet.css">
    <title>Create New Post</title>
</head>
<body>
    <div id="wrapper">
        <div id="header" class="header">
            <div id="left">
                <a id="home" href="index.php"><img id="Logo" src="imgs/Logo.png" alt="F1"></a>
                <a id="newPost" href="newPost.php"><svg id="plus_sign" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        viewBox="0 0 459.325 459.325"
                                                        xml:space="preserve">
                                                        <g>
                                                            <path d="M459.319,229.668c0,22.201-17.992,40.193-40.205,40.193H269.85v149.271c0,22.207-17.998,40.199-40.196,40.193
                                                                c-11.101,0-21.149-4.492-28.416-11.763c-7.276-7.281-11.774-17.324-11.769-28.419l-0.006-149.288H40.181
                                                                c-11.094,0-21.134-4.492-28.416-11.774c-7.264-7.264-11.759-17.312-11.759-28.413C0,207.471,17.992,189.475,40.202,189.475h149.267
                                                                V40.202C189.469,17.998,207.471,0,229.671,0c22.192,0.006,40.178,17.986,40.19,40.187v149.288h149.282
                                                                C441.339,189.487,459.308,207.471,459.319,229.668z"/>
                                                        </g>
                                                    </svg>
                    <div id="NewPostText">New Post</div>
                </a>
            </div>
            <div id="right">
                <a id="impressum" href="impressum.php">Impressum</a>
            </div>
        </div>
        <div id="body" class="body">
            <h1>New Post</h1>
            <form method="post" enctype="multipart/form-data">
                <div id="newPostForm">
                    <label for="username" class="usernameInputLabel">Username: </label>
                    <input type="text" class="usernameInput" id="username" name="username" required="required" maxlength="50" placeholder="Username">

                    <label for="title" class="titleInputLabel">Title: </label>
                    <input type="text" class="titleInput" id="title" name="title" required="required" maxlength="80" placeholder="Title">

                    <label for="contentInput" class="contentInputLabel">Content: </label>
                    <textarea name="content" class="contentInput" id="contentInput" required="required" maxlength="2000" placeholder="Content"></textarea>

                    <label for="fileInput" class="fileInputLabel">Select an Image: </label>
                    <div class="fileInputClass">
                        <input type="file" class="fileInput" id="fileInput" name="fileToUpload" accept=".jpeg, .png, .jpg, .gif" required="required">
                    </div>
                    <input type="submit" class="submitPost" name="submit" id="submit" value="POST!">
                </div>
            </form>
        </div>
        <?php
        //verkn??pft den fileManager
        require "fileManager.php";
        //Setzt den Error Handler fest
        set_error_handler("errorHandler");
        //falls der Submit Knopf gedr??ckt wurde wird die createPost Funktion ausgef??hrt mit den Daten aus dem Forum
        if(isset($_POST["submit"])){
            //tempor??rer php Name des Bildes
            $img_tmp_name = $_FILES['fileToUpload']['tmp_name'];
            //Name des Bildes
            $imgName = $_FILES['fileToUpload']['name'];
            //Gr??sse des Bildes
            $imgSize = $_FILES['fileToUpload']['size'];
            //Autor des Posts
            $username = $_POST['username'];
            //Titel des Posts
            $title = $_POST['title'];
            //Inhalt des Posts
            $content = $_POST['content'];
            //Funktion zum erstellen eines Posts
            createPost("$username","$title","$content","$img_tmp_name","$imgName","$imgSize");
        }
        ?>
    </div>
</body>
</html>
