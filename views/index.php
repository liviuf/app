<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


use MiniBlog\Articles;

$articles = new Articles();


$limit = 10;


$count = $articles->getCount();

$pages = ceil($count / $limit);

if (isset($_GET['page']) && $_GET['page'] != "") {
    $page = $_GET['page'];
    $offset = $limit * ($page - 1);
} else {
    $page = 1;
    $offset = 0;
}

$allArticles = $articles->getArticlesWithLimit($offset, $limit);
$categories = $articles->getAllCategories();

?>

<html>
    <head>
        <title>Mini Blog - HomePage</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
                    <li class="breadcrumb-item active" aria-current="page">Show All</li>
                </ol>
            </nav>
            <?php
            foreach ($allArticles as $article) {
                ?>
                <div class="card" id="article_<?php echo $article['article_id']; ?>">
                    <div class="row no-gutters">
                        <div class="col-auto">
                            <?php
                            echo '<img src="'.$article['image'].'" height="200px" width="200px" class="" alt="">';
                            ?>
                        </div>
                        <div class="col">
                            <div class="card-block px-2">
                                <?php
                                echo '<h4 class="card-title">' . $article["title"] . '</h4>';
                                ?>
                                <a href="/articles/category/<?php echo $article['category_id']; ?> "><h6 class="card-subtitle mb-2 text-muted"><?php echo $categories[$article["category_id"]] ?></h6></a>
                                <p class="card-text"><?php echo substr($article['content'], 0, 255); ?> ...</p>
                                <a href="/articles/view/<?php echo $article['article_id']; ?>" class="btn btn-primary" style=" position: absolute;right: 0;left: 5;bottom: 5;width: max-content; ">View Article</a>
                                <a href="/articles/update/<?php echo $article['article_id']; ?>" class="btn btn-default" style=" position: absolute;right: 0;left: 5;bottom: 5;width: max-content; margin-left: 400px ">Edit</a>
                                <a onclick="deleteArticle(this)" article-id=<?php echo $article['article_id']; ?> class="btn btn-danger" style=" position: absolute; right: 5;  bottom: 5; width: max-content" id="delete">Delete</a>
                            </div>
                        </div>
                    </div>

                </div>
                <?php
            }
            ?>

            <?php if($pages > 1) { ?>
            <nav aria-label="" style="margin-top:20px">
                <ul class="pagination">
                    <?php for($i = 1; $i<= $pages; $i++) { ?>
                    <li class="page-item"><a class="page-link" href="/articles?page=<?php echo $i; ?>"><?php echo $i;?></a></li>
                    <?php } ?>
                </ul>
            </nav>
            <?php } ?>
        </div>

        <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete article</h5>
                        <button type="button" id="modal_close" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this article?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="confirmDelete" class="btn btn-primary">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script>
            
           function deleteArticle(articleId) {
               $('.modal').modal('show');
               var id = $(articleId).attr('article-id');
                
               $('#confirmDelete').on('click', function(){
                   $.ajax({
                   url: '/articles/delete/' + id,
                   method: 'post'
                   }).done(function(output){
                       $("#modal_close").click();
                       $("#article_"+id).remove();
                   })
               })
                
                
                
           }
        
        </script>
    </body>
</html>




