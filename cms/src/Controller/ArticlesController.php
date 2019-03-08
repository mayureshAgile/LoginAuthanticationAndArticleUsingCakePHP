<?php
namespace App\Controller;
use \Imagick;
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
                $article->ImageName = $this-> uploadImage($this->request->data['upload']);
                $article->user_id = $this->Auth->user('id');
                $getFormvalue = $this->Articles->patchEntity($article, $this->request->data);
                if ($this->Articles->save($getFormvalue)) {
                    $this->Flash->success('Your profile has been sucessfully updated.');
                    return $this->redirect(['action' => 'index']);
                }else{
                    $this->Flash->error('Records not be saved. Please, try again.');
                }
        }
        $tags = $this->Articles->Tags->find('list');
        // Set tags to the view context
        $this->set('tags', $tags);
        $this->set('article', $article);
    }
     private function uploadImage($uploadDataArray){
        if (!empty($uploadDataArray)) {
            $file = $uploadDataArray; //put the data into a var for easy use
            //$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $mime_type = array(
                 'image/png',
                 'image/jpeg',
                 'image/jpeg',
                 'image/jpeg',
                 'image/gif'
            );
          $arr_ext = mime_content_type(WWW_ROOT.'img/'.$file['name']);
            //$arr_ext = array('jpg', 'jpeg', 'gif','png'); //set allowed extensions
            $setNewFileName = time() . "_" . rand(000000, 999999);
            //only process if the extension is valid
            if (in_array( $arr_ext,$mime_type)) {
                //do the actual uploading of the file. First arg is the tmp name, second arg is 
                //where we are putting it
                $return = move_uploaded_file($file['tmp_name'], WWW_ROOT . 'upload/avatar/'. $setNewFileName . '.' . $ext);
                if($return==1){
                    //prepare the filename for database entry 
                    $imageFileName = "";
                    $imageFileName = $setNewFileName . '.' . $ext;
                    list($width, $height) = getimagesize(WWW_ROOT . 'upload/avatar/'. $setNewFileName . '.' . $ext);
                   // $this->generateThumbnail($imageFileName, $width, $height);
                    try {
                       $this->generateThumbnail(WWW_ROOT . 'upload/avatar/'.$imageFileName, 100, 50, 65);
                    }
                    catch (ImagickException $e) {
                        echo $this->$e->getMessage();
                    }
                    catch (Exception $e) {
                        echo $this->$e->getMessage();
                    }
                }else{
                    $this-> echo("Image does not move to the loaction");
                }
            }
        }
//        if (!empty($uploadDataArray['name'])){
//            $getFormvalue->ImageName = $imageFileName;
//            pr($getFormvalue);exit('exit');
//        }
        return $imageFileName;
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
    private function generateThumbnail($img, $width, $height, $quality = 90)
    {
        if (is_file($img)) {
            $imagick = new Imagick(realpath($img));
            $imagick->setImageFormat('jpeg');
            $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
            $imagick->setImageCompressionQuality($quality);
            $imagick->thumbnailImage($width, $height, false, false);
            $filename_no_ext = reset(explode('.', $img));
            if (file_put_contents($filename_no_ext . '_thumb' . '.jpg', $imagick) === false) {
                throw new Exception("Could not put contents.");
            }
            return true;
        }else{
            throw new Exception("No valid image provided with {$img}.");
        }
    }
}