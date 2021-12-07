<?php
function text($username,$date,$title,$content,$imagename,$filename){
    return "<div class='postContent'>
                <div class='postHeader'>
                <div class='postUsername'><p><!---->$username<!----></p></div>
                <div class='postDate'><p><!---->$date<!----></p></div>
                </div>
                <div class='postTitle'><p><!---->$title<!----></p></div>
                <div class='postTuI'>
                <div class='postImageClass'><img class='postImage' src='$imagename' alt='Image'></div>
                <div class='postText'><p><!---->$content<!----></p></div>
                </div>
                <div class='postButtons'>
                <a class='editPost' href='editPost.php?editPost=$filename&editImage=$imagename'><div class='postEdit'>Edit</div></a>
                <a class='deletePost' href='fileManager.php?deletePost=$filename&deleteImage=$imagename'><div class='postDelete'>Delete</div></a>
                </div>
                </div>";
}
//Function for creating a Post
function createPost($usernameSource, $titleSource, $contentSource, $tmp_name, $imgName, $imgSize){
    //date and time variable for File sorting
    $dateFileName = date('Y-m-d_H-i-s', time());
    //date variable for displaying in Post
    $date = date('D, j.n.Y, H:i:s', time());
    //variable for old image name
    $target_file_name = basename($imgName);
    //retrieves the Suffix of the Image
    $imageFileType = strtolower(pathinfo($target_file_name, PATHINFO_EXTENSION));
    //variable for new image directory
    $target_dir = "imgs/";
    //variable for new Image path
    $imagename = $target_dir.$dateFileName.".".$imageFileType;
    //checks if Username exists, isn't empty and is less than 50 characters long
    if (isset($usernameSource)
    && !empty(trim($usernameSource))
    && strlen(trim($usernameSource)) < 51
    //checks if title exists, isn't empty and is less than 80 characters long
    && isset($titleSource)
    && !empty(trim($titleSource))
    && strlen(trim($titleSource)) < 81
    //checks if Content exists, isn't empty and is less than 2000 characters long
    && isset($contentSource)
    && !empty(trim($contentSource))
    && strlen(trim($contentSource)) < 2001
    // checks if image exists
    && isset($imgName)
    // checks if image is an actual Image
    && getimagesize($tmp_name) != false
    // checks if the image file arleady exists
    && file_exists($imagename) == false

    && file_exists($dateFileName) == false
    // checks if the image smaller than 500kb
    && $imgSize < 500000){
    // only if all of this is correct, the image and file get created
        //Variable uploadOK shouldn't change, unless there is a problem.
        $uploadOk = 1;
        // Allows certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $uploadOk = 0;
            echo "Fehler File type";
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "</br>Sorry, your image was not uploaded.";
            // if everything is ok, try to upload image
        } else {
            move_uploaded_file($tmp_name, $imagename);
        }
        //username entschärfen
        $username = htmlspecialchars(trim($usernameSource));
        //title entschärfen
        $title = htmlspecialchars(trim($titleSource));
        //content entschärfen
        $content = htmlspecialchars(trim($contentSource));
        $filename = 'posts/'.$dateFileName.'.txt';
        //create new File in dorectory posts with file name $date and Suffix .txt, in mode write
        $newFile = fopen($filename, "w");
        //writing the previous variable into the .txt file
        fwrite($newFile, text($username,$date,$title,$content,$imagename,$filename));
        //closing the new File after writing the Post
        fclose($newFile);
        //redirects to index.php automatically
        redirect("index.php");
    }
    else {echo "<h6>Sorry, something went wrong. Please Try again</h6>";}
}

function createEditedPostSameImage($usernameSource, $titleSource, $contentSource, $filename, $imagename, $date){
    //checks if Username exists, isn't empty and is less than 50 characters long
    if (isset($usernameSource)
    && !empty(trim($usernameSource))
    && strlen(trim($usernameSource)) < 51
    //checks if title exists, isn't empty and is less than 80 characters long
    && isset($titleSource)
    && !empty(trim($titleSource))
    && strlen(trim($titleSource)) < 81
    //checks if Content exists, isn't empty and is less than 2000 characters long
    && isset($contentSource)
    && !empty(trim($contentSource))
    && strlen(trim($contentSource)) < 2001
    && file_exists($filename)
    && file_exists($imagename)){
        // only if all of this is correct, the image and file get created
        //username entschärfen
        $username = htmlspecialchars(trim($usernameSource));
        //title entschärfen
        $title = htmlspecialchars(trim($titleSource));
        //content entschärfen
        $content = htmlspecialchars($contentSource);
        //create new File in directory posts with file name $date and Suffix .txt, in mode write
        $newFile = fopen($filename, "w");
        //writing the previous variable into the .txt file
        fwrite($newFile, text($username,$date,$title,$content,$imagename,$filename));
        //closing the new File after writing the Post
        fclose($newFile);
        //redirects to index.php automatically
        redirect("index.php");
    }
    else {echo "<h6>Sorry, something went wrong. Please Try again</h6>";}
}
function createEditedPostNewImage($usernameSource, $titleSource, $contentSource, $tmp_name, $imgName, $imgSize, $filename, $imagename, $date){
    //variable for old image name
    $target_file_name = basename($imgName);
    //retrieves the Suffix of the Image
    $imageFileType = strtolower(pathinfo($target_file_name, PATHINFO_EXTENSION));
    //checks if Username exists, isn't empty and is less than 50 characters long
    if (isset($usernameSource)
    && !empty(trim($usernameSource))
    && strlen(trim($usernameSource)) < 51
    //checks if title exists, isn't empty and is less than 80 characters long
    && isset($titleSource)
    && !empty(trim($titleSource))
    && strlen(trim($titleSource)) < 81
    //checks if Content exists, isn't empty and is less than 2000 characters long
    && isset($contentSource)
    && !empty(trim($contentSource))
    && strlen(trim($contentSource)) < 2001
    // checks if image exists
    && isset($imgName)
    // checks if image is an actual Image
    && getimagesize($tmp_name) != false
    // checks if the image smaller than 500kb
    && $imgSize < 500000
    && file_exists($filename)){
        // only if all of this is correct, the image and file get created
        //Variable uploadOK shouldn't change, unless there is a problem.
        $uploadOk = 1;
        // Allows certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $uploadOk = 0;
            echo "Fehler File type";
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "</br>Sorry, your image was not uploaded.";
            // if everything is ok, try to upload image
        } else {
            unlink($imagename);
            move_uploaded_file($tmp_name, $imagename);
        }
        //username entschärfen
        $username = htmlspecialchars(trim($usernameSource));
        //title entschärfen
        $title = htmlspecialchars(trim($titleSource));
        //content entschärfen
        $content = htmlspecialchars($contentSource);
        $newFile = fopen($filename, "w");
        //writing the previous variable into the .txt file
        fwrite($newFile, text($username,$date,$title,$content,$imagename,$filename));
        //closing the new File after writing the Post
        fclose($newFile);
        //redirects to index.php automatically
        redirect("index.php");
    }
    else {echo "<h6>Sorry, something went wrong. Please Try again</h6>";}
}
//Function to retrieve a textfiles content
function getPost($filename){
    // opens the specified File in read mode
    $readFile = fopen('posts/'.$filename, "r");
    $text = fread($readFile,filesize('posts/'.$filename));
    // closes the file after reading it
    fclose($readFile);
    // returns the content of the full File
    return $text;
}
//Function to delete a post
if(isset($_GET['deletePost'])
&& isset($_GET['deleteImage'])){
    deletePost($_GET['deletePost'],$_GET['deleteImage']);
}
function deletePost($filename,$imagename){
    unlink($filename);
    unlink($imagename);
    redirect("index.php");
}
//Function to get the amount of Files in a Folder
function folderSize($dir){
    //Presets the size to be 0
    $size = 0;
    //for each object in the specified directory it adds +1 to the size
    foreach(glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each){
        $size++;
    }
    //returns the size of the folder
    return $size;
}
//function to get the position of a file
function filePosition($dir, $num){
    //scanns the directory and puts it into an Array ordered descending
    $files = scandir("$dir", SCANDIR_SORT_DESCENDING);
    //returns the name of the file at the specified location in the array
    //$num refers to the file location in the array; 0 is the newest File
    return $files[$num];
}
//Function to redirect to a specified page
function redirect($url)
{
    //sets the URL with the page name
    echo "<meta http-equiv='refresh' content='0;url=$url'>";
    //stops running php script
    die();
}