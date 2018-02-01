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
