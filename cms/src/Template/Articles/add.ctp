<!-- File: src/Template/Articles/add.ctp -->

<h1>Add Article</h1>
<?php
    echo $this->Form->create($article,['enctype' => 'multipart/form-data']);
    // Hard code the user for now.
   // echo $this->Form->control('tags._ids', ['options' => $tags]);
    
    foreach ($tags as $tag) {
        $options[] =$tag;
    }
   // echo $this->Form->control('tags._ids', ['options' => $tags]);
    echo $this->Form->select(
        'field',
        $options
       // ['multiple' => 'chosen-select']
       // ['empty' => '(choose one)'],
        
    );
    echo $this->Form->control('tag_string', ['type' => 'text']);
    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->control('upload', ['type' => 'file']);
    echo $this->Form->control('title');
    echo $this->Form->control('body', ['rows' => '3']);
    echo $this->Form->button(__('Save Article'));
    echo $this->Form->end();
?>
<!--<div class="ChImg">
<?php 
//echo $this->Form->create($particularRecord, ['enctype' => 'multipart/form-data']);
//echo $this->Form->input('upload', ['type' => 'file']);
//echo $this->Form->button('Update Details', ['class' => 'btn btn-lg btn-success1 btn-block padding-t-b-15']);
//echo $this->Form->end();       
?>
</div>-->
