<div class="post-content">

    <div class="post" >
        <div class="blog-post-img" >
            <img src = <?= $model->img ?> >
            <div class="blog-post-features" >
                <span class="blog-post-category pink-color" > <?= $model->category ?> </span >
                <?php if(user_logged()) : ?>
                <span class="blog-post-favorite" id="<?= $model->PostID ?>" >
                    <i class="<?= (Data::is_favourite($_SESSION['login'], $model -> PostID)) ? 'fa-solid' : 'fa-regular' ?> fa-star" ></i > 
                </span >
                <?php endif; ?>
            </div >

        </div >
        
        <div class="description">
                
            <h1> <?= $model -> title ?> </h1>
                <?= $model-> content ?>
        </div>
    </div >

    <div class="author-content">
        <div class="author">
            <div class="sticky-div">
                <h1>Autor</h1>
                <p>Dodane przez: <?= $view_bag['author']?></p>
                <p>Ostatnia modyfikacja: </p>
                <p> <?= $model -> date ?> </p>
                <?php if(user_logged() && isset($_SESSION['admin'])) :?>
                <div class="post-menage">
                    <a class="btn" aria-current="page" href="admin?edit=<?= $model -> PostID?>">Edytuj</a> 
                    <a class="btn" aria-current="page" href="admin?delete=<?= $model -> PostID?>">Usuń</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>



<div class="comments-content">

    <div class="comments">
        <div class="commentsHeader">
            <h1>Komentarze</h1>

            <?php  if(user_logged()) :?>
                <a class="btn" id="commentControl" aria-current="page">Dodaj komentarz </a>
            <?php endif; ?>

        </div>
            
        <?php foreach (Data::get_comments( $model->PostID, isset($_SESSION['login']) ? $_SESSION['login'] : null )['comments'] as $item) :

            echo $item;

         endforeach; ?>
        

    </div>

</div>


<script src="app/comments_form.js"></script>
<?= (user_logged()) ? '<script src="app/post_like.js"></script>' : '' ?> 