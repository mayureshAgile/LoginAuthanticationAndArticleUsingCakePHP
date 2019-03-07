<!-- File: src/Template/Articles/edit.ctp -->

<h1>Edit Article</h1>
<p class="edit_tag">
<?php
    echo $this->Form->create($article);
    ?>
    <label>Tags</label><input type="text" data-role="tagsinput" value="<?php echo $article['tags'][0]['title']; ?>">
    <?php
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
    echo $this->Form->control('user_id', ['type' => 'hidden']);
    echo $this->Form->control('title',[]);
    echo $this->Form->control('body', ['rows' => '3']);
    echo $this->Form->button(__('Save Article'));
    echo $this->Form->end();
?>
</p>