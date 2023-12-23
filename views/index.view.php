
<div class="blog-content-posts" >

    <?php foreach ($model as $item) :?>

            <div class="post" >
                <a href="detail?post=<?= $item->PostID ?>">
                    <div class="blog-post-img" >
                        <img src = <?= $item->img ?> >
                        <div class="blog-post-features" >
                            <span class="blog-post-category pink-color" > <?= $item->category ?> </span >
                            <?php if(user_logged()) : ?>
                            <span class="blog-post-favorite" id="<?= $item->PostID ?>" >
                                <i class="<?= (Data::is_favourite($_SESSION['login'], $item -> PostID)) ? 'fa-solid' : 'fa-regular' ?> fa-star" ></i > 
                            </span >
                            <?php endif; ?>
                        </div >

                    </div >

                    <div class="under-img">
                        <div class="blog-post-info" >
                            <div class="blog-post-info-left" >
                                <span class="post-stats" > <?= $item->date ?> </span ><span class="post-stats" > <i class="fa-regular fa-clock" ></i > <?= $item->time ?> minut </span >
                            </div >

                            <div class="blog-post-info-right" >
                                <span class="post-stats" ><i class="fa-solid fa-message pink-color" ></i > <?= $item->comments ?> </span ><span class="post-stats" > <i class="fa-regular fa-heart" ></i > <?= $item-> likes?></span >
                            </div >

                        </div >

                        <h2 class="blog-post-tittle" > <?= $item->title ?></h2 >

                        <div class="blog-post-text" >
                            <span > <?= $item->description ?></span >
                            <span ><i class="fa-solid fa-arrow-right pink-color" ></i ></span >
                        </div >
                    </div>
                </a>
            </div >
    <?php endforeach;?>
</div>

<?= (user_logged()) ? '<script src="app/post_like.js"></script>' : '' ?> 