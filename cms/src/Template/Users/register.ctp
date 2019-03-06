<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="container py-5" style="background-color: #E7DFDD;">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 mx-auto">

                    <!-- form card login -->
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="mb-0">User Registration</h3>
                        </div>
                        <div class="card-body">
                            <div class="users form large-9 medium-8 columns content">
                                <?= $this->Form->create($user) ?>
                                <fieldset>
                                    <?php
                                        echo $this->Form->control('email');
                                        echo $this->Form->control('password');
                                        echo $this->Form->control('cPassword');

                                    ?>
                                </fieldset>
                                <?= $this->Form->button(__('Submit')) ?>
                                <?= $this->Form->end() ?>
                            </div>
                            <div class=""><?= $this->Html->link(__('login User'), ['controller' => 'Users', 'action' => 'login']) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
