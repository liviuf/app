<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use MiniBlog\Articles;

$articles = new Articles();

$request = $_SERVER['REQUEST_URI'];

$exploded = explode('/', $request);

$articleId = end($exploded);

$article = $articles->findById($articleId);

?>

<html>
<head>
<title>Mini Blog - HomePage</title>
<link rel = "stylesheet" href = "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity = "sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin = "anonymous">
</head>
<body>
<?php
include(APPLICATION_PATH . '/vendor/header.php');
?>
        
        <div class="container" style="padding-top:20px">
            
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/articles">Articles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View</li>
                </ol>
            </nav>

                    <div class="card" id="article_<?php echo $article['article_id']; ?>">
                        <div class="row no-gutters">
                            <div class="col-auto">
    <?php
    echo '<img src="' . $article['image'] . '" height="200px" width="200px" class="" alt="">';
    ?>
                            </div>
                            <div class="col">
                                <div class="card-block px-2">
    <?php
    echo '<h4 class="card-title">' . $article["title"] . '</h4>';
    ?>
                                    <a href="/articles/category/<?php echo $article['category_id']; ?> "><h6 class="card-subtitle mb-2 text-muted"><?php echo $categories[$article["category_id"]] ?></h6></a>
                                    <p class="card-text"><?php echo $article['content']; ?> </p>
                                </div>
                            </div>
                        </div>

                    </div>

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
     
    </body>
</html>



