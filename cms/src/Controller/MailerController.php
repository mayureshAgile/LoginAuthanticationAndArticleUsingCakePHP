<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Mailer Controller
 *
 *
 * @method \App\Model\Entity\Mailer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MailerController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $mailer = $this->paginate($this->Mailer);

        $this->set(compact('mailer'));
    }

    /**
     * View method
     *
     * @param string|null $id Mailer id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mailer = $this->Mailer->get($id, [
            'contain' => []
        ]);

        $this->set('mailer', $mailer);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mailer = $this->Mailer->newEntity();
        if ($this->request->is('post')) {
            $mailer = $this->Mailer->patchEntity($mailer, $this->request->getData());
            if ($this->Mailer->save($mailer)) {
                $this->Flash->success(__('The mailer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mailer could not be saved. Please, try again.'));
        }
        $this->set(compact('mailer'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Mailer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mailer = $this->Mailer->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mailer = $this->Mailer->patchEntity($mailer, $this->request->getData());
            if ($this->Mailer->save($mailer)) {
                $this->Flash->success(__('The mailer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mailer could not be saved. Please, try again.'));
        }
        $this->set(compact('mailer'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Mailer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mailer = $this->Mailer->get($id);
        if ($this->Mailer->delete($mailer)) {
            $this->Flash->success(__('The mailer has been deleted.'));
        } else {
            $this->Flash->error(__('The mailer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
