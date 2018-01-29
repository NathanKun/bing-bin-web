<?= form_open('app/getEcoPoint'); ?>

                    <?= form_input(array(
                            'name' => 'login',
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

<?= form_open('welcome/register'); ?>

<?= form_input(array(
                            'name' => 'name',
                            'class' => 'form-control input-small',
                            'placeholder' => 'name'
                        )
                    ) ?>

<?= form_input(array(
                            'name' => 'mail',
                            'class' => 'form-control input-small',
                            'placeholder' => 'mail'
                        )
                    ) ?>

<?= form_submit(array(
                'name' => 'submit',
                'value' => 'Test',
                'class' => 'btn btn-primary'
            )); ?>

<?= form_close(); ?>
