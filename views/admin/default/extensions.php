<div class="card">
    <div class="card-header">
        <h5>Extensions</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Name</th>
            </tr>
            <?php foreach (Yii::$app->extensions as $pack) { ?>
                <tr>
                    <td><strong><?= $pack['name']; ?></strong> <span class="badge badge-light">(<?= $pack['version']; ?>)</span>

                        <?php foreach ($pack['alias'] as $alias => $path) { ?>
                            <div>
                                <code><?= $alias; ?></code> =>
                                <small><?= $path; ?></small>
                            </div>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
