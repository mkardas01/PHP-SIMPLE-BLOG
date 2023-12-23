<div class="container">
    <form method="post">

        <div class="form-group">
            <label for="img">Zdjęcie</label>
            <textarea class="form-control" id="img" name="img" rows="1"> <?php if(isset($model->img)) echo $model->img ?> </textarea>
        </div>

        <div class="form-group">
            <label for="title">Tytuł</label>
            <textarea class="form-control" id="title" name="title" rows="1"><?php if(isset($model->title)) echo $model->title?></textarea>
        </div>

        <div class="form-group">
            <label for="category">Kategoria</label>
            <textarea class="form-control" id="category" name="category" rows="1"> <?php if(isset($model->category)) echo $model->category?></textarea>
        </div>

        <div class="form-group">
            <label for="time">Czas</label>
            <textarea class="form-control" id="time" name="time" rows="1"> <?php if(isset($model->category)) echo $model->time?> </textarea>
        </div>

        <div class="form-group">
            <label for="content">Krótki opis</label>
            <textarea class='form-control' id="content" name="description" rows="1" maxlength="103"><?php if(isset($model->description)) echo $model->description?> </textarea>
        </div>

        <div class="form-group">
            <label for="content">Tekst</label>
            <textarea class='form-control' id="content" name="content" rows="2"><?php if(isset($model->content)) echo $model->content?> </textarea>
        </div>

        <textarea name="PostID" hidden><?php if(isset($model->PostID)) echo $model->PostID?> </textarea>

        <div class="form-submit">
            <button type="submit" class="btn" id="save_post" name="save_post" value="save_post">Zapisz</button>
        </div>

    </form>
</div>
    <script src="app/resize_form.js"></script>