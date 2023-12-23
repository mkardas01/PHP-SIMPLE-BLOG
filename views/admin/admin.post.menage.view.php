<div class="container">
    <table>
                <tr>
                    <th>Tytuł</th>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Akcja</th>
                </tr>

                <?php foreach ($model as $item) :?>
                    <tr>
                        <td> <a href='detail.php?post=<?= $item -> PostID ?>'><?= $item -> title ?></a></td>
                        <td> <?= $item -> PostID ?></td>
                        <td> <?= $item -> date ?></td>
                        <td> 
                            <a class="btn ml-3" aria-current="page" href="admin?edit=<?= $item -> PostID?>">Edytuj</a> 
                            <a class="btn ml-3" aria-current="page" href="admin?delete=<?= $item -> PostID?>">Usuń</a>
                        </td>
                    </tr>
                <?php endforeach;?>

    </table>
</div>