<!-- File: src/Template/Articles/index.ctp  (edit links added) -->

<h1>Articles</h1>
<p><?= $this->Html->link("Add Article", ['action' => 'add']) ?></p>

<?php foreach ($articles as $article): ?>
<div class="card">
    <div class="card-img-top" style="width:200px">
      <?php
      if($article['ImageName']){
          echo $this->Html->image('/upload/avatar/'.$article['ImageName'].'');
      }else{
          echo $this->Html->image('img_avatar.png', ['alt' => 'Avtar_Image']);
      }?>
    </div>
    <div class="card-body">
        <h4 class="card-title"><?= $this->Html->link($article->title, ['action' => 'view', $article->slug]) ?></h4>
        <div class="card-header text-center">
            <b> <?php echo $article['body']; ?></b>
        </div>
        <div class="card-text text-right">
            <small>Created: <?= $article->created->format(DATE_RFC850) ?></small><br>
            <a href="#" ><?= $this->Html->link('Edit', ['action' => 'edit', $article->slug]) ?></a>
            <a href="#" ><?= $this->Form->postLink(
                          'Delete',
                          ['action' => 'delete', $article->slug],
                          ['confirm' => 'Are you sure?'])
                      ?>
            </a>
        </div>
    </div>
</div>
<br>
<br>
<?php endforeach; ?>