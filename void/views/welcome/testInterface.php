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

<?= form_open('app/getrank'); ?>

<?= form_input(array(
                            'name' => 'BingBinToken',
                            'class' => 'form-control input-small',
                            'placeholder' => 'get rank'
                        )
                    ) ?>
<?= form_submit(array(
                'name' => 'submit',
                'value' => 'Test',
                'class' => 'btn btn-primary'
            )); ?>

<?= form_close(); ?>

<?= form_open('app/uploadScan'); ?>

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
<?= form_submit(array(
                'name' => 'submit',
                'value' => 'Test',
                'class' => 'btn btn-primary'
            )); ?>

<?= form_close(); ?>

<form method="post" action="<?= site_url('app/testImg'); ?>" enctype="multipart/form-data">

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
