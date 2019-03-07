<div class="container py-5" style="background-color: #E7DFDD;">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 mx-auto">

                    <!-- form card login -->
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="mb-0">Login</h3>
                        </div>
                        <div class="card-body">
                            <?= $this->Form->create() ?>
                            <?= $this->Form->control('email') ?>
                            <?= $this->Form->control('password') ?>
                            <?= $this->Form->button('Login') ?>
                            <?= $this->Html->link(__('Register User'), ['controller' => 'Users', 'action' => 'register']) ?>
                            <?= $this->Html->link(__('Forgot Password'), ['controller' => 'Users', 'action' => 'checkpassword']) ?>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                   