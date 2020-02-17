<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use MiniBlog\Articles;
use MiniBlog\Config;

$request = $_SERVER['REQUEST_URI'];
$exploded = explode('/', $request);

$id = end($exploded);


$articles = new Articles();
$categories = $articles->getAllCategories();
$article = $articles->findById($id);

if(isset($_POST) && !empty($_POST)) {
    
    $config = new Config();
    
    $storagePath = $config->config['storage_path'];
    $destination = APPLICATION_PATH . $storagePath;
    
    if (!file_exists($destination)) {
        if(!mkdir($destination, 0775, true)) {
            throw new Exception('The storage could not be created.');
        }
    }

    if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
        $newFileName = uniqid();
        move_uploaded_file($_FILES['image']['tmp_name'], $destination . $newFileName);
        $imgPath = $storagePath . $newFileName;
    } else {
        $imgPath = $article['image'];
    }
    
    
    
    if(isset($_POST['articleTitle'])) {
        $title = htmlentities($_POST['articleTitle']);
    } 
    if(isset($_POST['articleDescription'])) {
        $content = htmlentities($_POST['articleDescription']);
    }
    if(isset($_POST['articleCategory'])) {
        $category = $_POST['articleCategory'];
    }
    

    $articles = new Articles();
    $articles->updateArticle($id,$title, $content, $category, $imgPath);
    
    header("Location: /articles"); 
    die();
} 




//print_r([$article]);

//die();

?>
<html>
    <head>
        <title>Mini Blog - Update Article</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
    <?php 
    include(APPLICATION_PATH . '/vendor/header.php');
    ?>    
        
        <div class="container" style="padding-top: 20px">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/articles">Articles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Article</li>
                </ol>
            </nav>
            
            <form action="/articles/update/<?php echo $id;?>" method="post" enctype="multipart/form-data" class="">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="articleTitle">Title</label>
                        <input type="text" class="form-control" id="articleTitle" placeholder="" value="<?php echo $article['title']; ?>" name="articleTitle" >
<!--                        <div class="valid-feedback" style="">
                            Looks good!
                        </div>-->
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="articleDescription">Description</label>
                        <textarea class="form-control" id="articleDescription" name="articleDescription" value="" rows="4" cols="50"><?php echo $article['content']; ?>
                        </textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <select class="custom-select" required name="articleCategory" id="articleCategory">
                            <option value="">Select Category</option>
                            <?php foreach($categories as $categoryId => $title) {?>
                            <option value="<?php echo $categoryId; ?>" <?php if($article['category_id'] == $categoryId) { echo "selected"; } ?> ><?php echo $title; ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">Not valid</div>
                    </div>
                    <div class="col-auto">
                            <?php
                            echo '<img src="'.$article['image'].'" height="200px" width="200px" class="" alt="">';
                            ?>
                    </div>
                    
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image" id="validatedCustomFile" >
                        <label class="custom-file-label" for="">Choose file...</label>
                        <div class="invalid-feedback" style="">Invalid file </div>
                    </div>
                </div>
               
                <button class="btn btn-primary" type="submit" style="margin-top:50px">Update article</button>
            </form>

            
        </div>
        
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>