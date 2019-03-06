<h1 class="alert-info"><center><?= h($article->title) ?></center></h1>
<div class="container">
    <div class="form-group">
        <div class="row card bg-light">
             <div class="card-img-top" style="width:200px">
                <?php if($article['ImageName']){
                    echo $this->Html->image('/upload/avatar/'.$article['ImageName'].'');
                }else{
                    echo $this->Html->image('img_avatar.png', ['alt' => 'Avtar_Image']);
                }?>
            </div>
            <div class="card-body text-center">
                <center><?= h($article->body) ?></center>
            </div>
           
            <div class="card-header text-center">
                <b>Tags:</b> <?= h($article->tag_string) ?>
            </div>
            <div class="">
                <button  type="button" class="pull-left btn-group btn-group-sm btn btn-outline-info" style="text-decoration: none;"><?= $this->Html->link('Edit' , ['action' => 'edit',$article->slug,'_full' => true]) ?></button>

                <div class=" card-text text-right"><small>Created: <?= $article->created->format(DATE_RFC850) ?></small></div>
            </div>
            
        </div>
    </div>
</div>
