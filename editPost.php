<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesheet.css">
    <title>Edit Post</title>
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
            <h1>Edit Post</h1>
                <?php
                //verknüpft den fileManager
                require "fileManager.php";
                //Setzt den Error Handler fest
                set_error_handler("errorHandler");
                //falls die Daten über die Get Methode angegeben wurden, wird der rest ausgeführt, sonst wird wieder auf index.php redirected
                if(isset($_GET['editPost'])
                && isset($_GET['editImage'])){
                    $get_filename = $_GET['editPost'];
                    $get_imagename = $_GET['editImage'];
                    //öffnet die angegebene Datei im read mode und setzt den Inhalt in eine Variabel
                    $editFile = fopen($get_filename,"r");
                    $String = fread($editFile,filesize($get_filename));
                    //Trennt den Inhalt und setzt die richtigen Werte fest
                    $array = explode("<!---->",$String);
                    $username = $array[1];
                    $date = $array[3];
                    $title = $array[5];
                    $content = $array[7];
                    //Gibt ein Forum aus mit den Daten aus der Datei als values
                    echo "<form method='post' enctype='multipart/form-data'>
                            <div id='newPostForm'>
                                <label for='username' class='usernameInputLabel'>Username: </label>
                                <input type='text' name='username' id='username' class='usernameInput' required='required' maxlength='50' value='$username' placeholder='Username'>
                            
                                <label for='title' class='titleInputLabel'>Title:</label>
                                <input type='text' class='titleInput' name='title' id='title' required='required' maxlength='80' value='$title' placeholder='Title'>
                            
                                <label for='content' class='contentInputLabel'>Content: </label>
                                <textarea name='content' class='contentInput' id='content' required='required' maxlength='2000' placeholder='Content'>$content</textarea>
                                
                                <div class='existingImageLabel'>Keep current Image?</div>
                                <img id='existImage' alt='Image' class='existingImage' src='$get_imagename'>
                            
                                <label for='fileToUpload' class='fileInputLabel'>Or select a new Image: </label>
                                <div class='fileInputClass'>
                                    <input type='file' class='fileInput' name='fileToUpload' id='fileToUpload' accept='.jpeg, .png, .jpg, .gif'>
                                </div>
                                
                                
                                <input type='submit' class='submitPost' name='submit' id='submit' value='POST!'>
                            </div>
                        </form>";
                    //falls der Submit Knopf gedrückt wurde...
                    if(isset($_POST["submit"])){
                        //falls der FileUpload nicht leer ist... sonst
                        if(!empty($_FILES['fileToUpload']['size'])){
                            //temporärer php Name des Bildes
                            $img_tmp_name = $_FILES['fileToUpload']['tmp_name'];
                            //Name des Bildes
                            $imgName = $_FILES['fileToUpload']['name'];
                            //Grösse des Bildes
                            $imgSize = $_FILES['fileToUpload']['size'];
                            //Autor des Posts
                            $usernameNew = $_POST['username'];
                            //Titel des Posts
                            $titleNew = $_POST['title'];
                            //Inhalt des Posts
                            $contentNew = $_POST['content'];
                            //Funktion zum Erstellen eines editierten Posts mit neuem Bild
                            createEditedPostNewImage("$usernameNew","$titleNew","$contentNew","$img_tmp_name","$imgName","$imgSize","$get_filename", "$get_imagename","$date");
                        }else{
                            //Autor des Posts
                            $usernameNew = $_POST['username'];
                            //Titel des Posts
                            $titleNew = $_POST['title'];
                            //Inhalt des Posts
                            $contentNew = $_POST['content'];
                            //Funktion zum Erstellen eines editierten Posts ohne neuem Bild
                            createEditedPostSameImage("$usernameNew","$titleNew","$contentNew","$get_filename","$get_imagename","$date");
                        }
                    }
                }else{redirect("index.php");}
                ?>
        </div>

        <div id="footer" class="footer">
        </div>
    </div>
</body>
</html>