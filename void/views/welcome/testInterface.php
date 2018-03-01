<?= form_open('app/loginAuthorize'); ?>

                    <?= form_input(array(
                            'name' => 'pseudo',
                            'class' => 'form-control input-small',
                            'placeholder' => 'Login'
                        )
                    ) ?>

                    <?= form_password(array(
                            'name' => 'password',
                            'class' => 'form-control input-small',
                            'placeholder' => 'password'
                        )
                    ) ?>

                    <?= form_input(array(
                            'name' => 'field',
                            'class' => 'form-control input-small',
                            'placeholder' => 'A Basic Field'
                        )
                    ) ?>

<?= form_submit(array(
                'name' => 'submit',
                'value' => 'Test',
                'class' => 'btn btn-primary'
            )); ?>

<?= form_close(); ?>

<?= form_open('app/getmyinfo'); ?>

<?= form_input(array(
                            'name' => 'BingBinToken',
                            'class' => 'form-control input-small',
                            'placeholder' => 'name'
                        )
                    ) ?>
<?= form_submit(array(
                'name' => 'submit',
                'value' => 'Test',
                'class' => 'btn btn-primary'
            )); ?>

<?= form_close(); ?>

<?= form_open('ranking/getladder'); ?>

<?= form_input(array(
                            'name' => 'BingBinToken',
                            'class' => 'form-control input-small',
                            'placeholder' => 'token getLadder'
                        )
                    ) ?>
                    <?= form_input(array(
                            'name' => 'Duration',
                            'class' => 'form-control input-small',
                            'placeholder' => 'Duration'
                        )
                    ) ?>
                    <?= form_input(array(
                            'name' => 'limit',
                            'class' => 'form-control input-small',
                            'placeholder' => 'limit'
                        )
                    ) ?>
<?= form_submit(array(
                'name' => 'submit',
                'value' => 'Test',
                'class' => 'btn btn-primary'
            )); ?>

<?= form_close(); ?>

<?= form_open('app/getMyScanHistory'); ?>

<?= form_input(array(
                            'name' => 'BingBinToken',
                            'class' => 'form-control input-small',
                            'placeholder' => 'token scan histo'
                        )
                    ) ?>
                    <?= form_input(array(
                            'name' => 'limit',
                            'class' => 'form-control input-small',
                            'placeholder' => 'limit'
                        )
                    ) ?>
            <?= form_submit(array(
                'name' => 'submit',
                'value' => 'Test',
                'class' => 'btn btn-primary'
            )); ?>

<?= form_close(); ?>

<?= form_open('app/sendSunPoint'); ?>

<?= form_input(array(
                            'name' => 'BingBinToken',
                            'class' => 'form-control input-small',
                            'placeholder' => 'token sun'
                        )
                    ) ?>
                    <?= form_input(array(
                            'name' => 'targetId',
                            'class' => 'form-control input-small',
                            'placeholder' => 'targetID'
                        )
                    ) ?>
<?= form_submit(array(
                'name' => 'submit',
                'value' => 'Test',
                'class' => 'btn btn-primary'
            )); ?>

<?= form_close(); ?>
<?= form_open('app/getMySunPointHistory'); ?>

<?= form_input(array(
                            'name' => 'BingBinToken',
                            'class' => 'form-control input-small',
                            'placeholder' => 'sun sol'
                        )
                    ) ?>
<?= form_submit(array(
                'name' => 'submit',
                'value' => 'Test',
                'class' => 'btn btn-primary'
            )); ?>

<?= form_close(); ?>

<?= form_open('app/getMySummary'); ?>

<?= form_input(array(
                            'name' => 'BingBinToken',
                            'class' => 'form-control input-small',
                            'placeholder' => 'summary'
                        )
                    ) ?>
<?= form_submit(array(
                'name' => 'submit',
                'value' => 'Test',
                'class' => 'btn btn-primary'
            )); ?>

<?= form_close(); ?>


<?= form_open('app/getTrashesCategories'); ?>

    <?= form_input(array(
                                'name' => 'BingBinToken',
                                'class' => 'form-control input-small',
                                'placeholder' => 'get categories'
                            )
                        ) ?>
    <?= form_submit(array(
                    'name' => 'submit',
                    'value' => 'Test',
                    'class' => 'btn btn-primary'
                )); ?>

<?= form_close(); ?>



<form method="post" action="<?= site_url('app/uploadscan'); ?>" enctype="multipart/form-data">
    <?= form_input(array(
                            'name' => 'BingBinToken',
                            'class' => 'form-control input-small',
                            'placeholder' => 'get rank'
                        )
                    ) ?>
                    <?= form_input(array(
                            'name' => 'trashName',
                            'class' => 'form-control input-small',
                            'placeholder' => 'get rank'
                        )
                    ) ?>
                    <?= form_input(array(
                            'name' => 'trashCategory',
                            'class' => 'form-control input-small',
                            'placeholder' => 'get rank'
                        )
                    ) ?>

        <input type="file" name="img"/>
        <?= form_submit(array(
                        'name' => 'submit',
                        'value' => 'Test',
                        'class' => 'btn btn-primary'
                    )); ?>

<?= form_close(); ?>



<?= form_open('app/registerValidation'); ?>

    <?= form_input(array(
                                'name' => 'name',
                                'class' => 'form-control input-small',
                                'placeholder' => 'name'
                            )
                        ) ?>
                        <?= form_input(array(
                                'name' => 'firstname',
                                'class' => 'form-control input-small',
                                'placeholder' => 'firstname'
                            )
                        ) ?>
                        <?= form_input(array(
                                'name' => 'email',
                                'class' => 'form-control input-small',
                                'placeholder' => 'email'
                            )
                        ) ?>
                        <?= form_input(array(
                                'name' => 'pseudo',
                                'class' => 'form-control input-small',
                                'placeholder' => 'pseudo'
                            )
                        ) ?>
                        <?= form_input(array(
                                'name' => 'password',
                                'class' => 'form-control input-small',
                                'placeholder' => 'password'
                            )
                        ) ?>
    <?= form_submit(array(
                'name' => 'submit',
                'value' => 'Test',
                'class' => 'btn btn-primary'
            )); ?>

<?= form_close(); ?>
