<?php
namespace App\Controller;

use App\Controller\AppController;

class ArticlesController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }
    public function index()
    {
        $articles = $this->Paginator->paginate($this->Articles->find());
        $this->set(compact('articles'));
    }
    public function view($slug)
    {
       $article = $this->Articles->findBySlug($slug)->contain(['Tags'])
        ->firstOrFail();
        $this->set(compact('article'));
    }
    public function add()
    {
        $article = $this->Articles->newEntity();
        if (!empty($this->request->data)) {

            if (!empty($this->request->data['upload'])) {
                $file = $this->request->data['upload']; //put the data into a var for easy use
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension


                $arr_ext = array('jpg', 'jpeg', 'gif','png'); //set allowed extensions
                $setNewFileName = time() . "_" . rand(000000, 999999);

                //only process if the extension is valid
                if (in_array($ext, $arr_ext)) {
                    //do the actual uploading of the file. First arg is the tmp name, second arg is 
                    //where we are putting it
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'upload/avatar/'. $setNewFileName . '.' . $ext);

                    //prepare the filename for database entry 
                    $imageFileName = $setNewFileName . '.' . $ext;

                }
            }
            $article->user_id = $this->Auth->user('id');

            $getFormvalue = $this->Articles->patchEntity($article, $this->request->data);


            if (!empty($this->request->data['upload']['name'])) {
                    $getFormvalue->ImageName = $imageFileName;
            }
            if ($this->Articles->save($getFormvalue)) {
                $this->Flash->success('Your profile has been sucessfully updated.');
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error('Records not be saved. Please, try again.');
            }
        }
//        if ($this->request->is('post')) {
//            $article = $this->Articles->patchEntity($article, $this->request->getData());
//
//            // Changed: Set the user_id from the session.
//            $article->user_id = $this->Auth->user('id');
//
//            if ($this->Articles->save($article)) {
//                $this->Flash->success(__('Your article has been saved.'));
//                return $this->redirect(['action' => 'index']);
//            }
//           
//            $this->Flash->error(__('Unable to add your article.'));
//        }
        $tags = $this->Articles->Tags->find('list');

        // Set tags to the view context
        $this->set('tags', $tags);
//
        $this->set('article', $article);
    }
    public function edit($slug)
    {
         $article = $this->Articles
        ->findBySlug($slug)
        ->contain('Tags') // load associated Tags
        ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->getData(), [
                // Added: Disable modification of user_id.
                'accessibleFields' => ['user_id' => false]
            ]);
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }
        $tags = $this->Articles->Tags->find('list');
    // Set tags to the view context
        $this->set('tags', $tags);
        $this->set('article', $article);
        //$this->set('Tags', $tags);
    }
    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);

        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The {0} article has been deleted.', $article->title));
            return $this->redirect(['action' => 'index']);
        }
    }
    public function tags()
    {
        // The 'pass' key is provided by CakePHP and contains all
        // the passed URL path segments in the request.
        $tags = $this->request->getParam('pass');

        // Use the ArticlesTable to find tagged articles.
        $articles = $this->Articles->find('tagged', [
            'tags' => $tags
        ]);

        // Pass variables into the view template context.
        $this->set([
            'articles' => $articles,
            'tags' => $tags
        ]);
    }
    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        // The add and tags actions are always allowed to logged in users.
        if (in_array($action, ['add', 'tags'])) {
            return true;
        }

        // All other actions require a slug.
        $slug = $this->request->getParam('pass.0');
        if (!$slug) {
            return false;
        }

        // Check that the article belongs to the current user.
        $article = $this->Articles->findBySlug($slug)->first();

        return $article->user_id === $user['id'];
    }
}