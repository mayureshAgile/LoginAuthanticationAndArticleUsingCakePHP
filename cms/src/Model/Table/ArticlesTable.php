<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use Cake\ORM\Query;
class ArticlesTable extends Table
{
    public $fixtures = ['app.Articles'];
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Tags', [
        'joinTable' => 'articles_tags',
        'dependent' => true
        ]);
    }
    public function beforeSave($event, $entity, $options)
    {
//        pr($event);
//        pr($entity);
//        pr($options);        
//        exit("ex");
        if ($entity->tag_string) {
            $entity->tags = $this->_buildTags($entity->tag_string);
        }
        if ($entity->isNew() && !$entity->slug) {
            $sluggedTitle = Text::slug($entity->title);
            // trim slug to maximum length defined in schema
            $entity->slug = substr($sluggedTitle, 0, 191);
        }
    }
    public function validationEdit(Validator $validator)
    {
        $validator
                ->allowEmptyString('title', false)
                ->minLength('title', 10)
                ->maxLength('title', 255)
                ->allowEmptyString('body', false)
                ->minLength('body', 10)
                ->add('upload', 'custom', [
                        'rule' => [$this, 'validationImage'],
                        'message' => 'Image is required'
                ]);
        return $validator;
    }
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmptyString('title', false)
            ->minLength('title', 10)
            ->maxLength('title', 255)
            ->allowEmptyString('body', false)
            ->minLength('body', 10);
        return $validator;
    }
    public function validationImage($check, array $context){
        $mime_type = array(
                 'image/png',
                 'image/jpeg',
                 'image/jpeg',
                 'image/jpeg',
                 'image/gif'
        );
       $arr_ext = mime_content_type(WWW_ROOT.'img/'.$check['name']);
        if (in_array( $arr_ext,$mime_type)) {
             $return = true;
        }else{
             $return = false;
        }
        return $return;
    }
    public function findTagged(Query $query, array $options)
    {
        $columns = [
            'Articles.id', 'Articles.user_id', 'Articles.title',
            'Articles.body', 'Articles.published', 'Articles.created',
            'Articles.slug', 'Articles.ImageName',
        ];
        $query = $query
            ->select($columns)
            ->distinct($columns);
   

        if (empty($options['tags'])) {
            // If there are no tags provided, find articles that have no tags.
            $query->leftJoinWith('Tags')
                ->where(['Tags.title IS' => null]);
        } else {
            // Find articles that have one or more of the provided tags.
            $query->innerJoinWith('Tags')
                ->where(['Tags.title IN' => $options['tags']]);
        }
        return $query->group(['Articles.id']);
    }
     public function findPublished(Query $query, array $options)
    {
        $query->where([
            $this->alias() . '.published' => 1
        ]);
        return $query;
    }
    protected function _buildTags($tagString)
    {
         
        // Trim tags
        $newTags = array_map('trim', explode(',', $tagString));
        // Remove all empty tags
        $newTags = array_filter($newTags);
        // Reduce duplicated tags
        $newTags = array_unique($newTags);

        $out = [];
        $query = $this->Tags->find()
            ->where(['Tags.title IN' => $newTags]);

        // Remove existing tags from the list of new tags.
        foreach ($query->extract('title') as $existing) {
            $index = array_search($existing, $newTags);
            if ($index !== false) {
                unset($newTags[$index]);
            }
        }
        // Add existing tags.
        foreach ($query as $tag) {
            $out[] = $tag;
        }
        // Add new tags.
        foreach ($newTags as $tag) {
            $out[] = $this->Tags->newEntity(['title' => $tag]);
        }
        return $out;
    }
}