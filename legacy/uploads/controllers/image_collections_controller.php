<?php

class ImageCollectionsController extends UploadsAppController
{
    public $name = 'ImageCollections';

    public $layout = 'backend';

    public $helpers = array('Ui.Table', 'Uploads.Upload');

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow(array('images', 'collection'));
    }

    public function index()
    {
        $this->ImageCollection->recursive = 0;
        $this->set('imageCollections', $this->paginate());
    }

    public function add()
    {
        if (!empty($this->data['Item'])) {
            $this->ImageCollection->create();
            $this->ImageCollection->init();
            if ($this->ImageCollection->save()) {
                $this->message('success');
                unset($this->data['ImageCollection']);
                $this->setAction('edit', $this->ImageCollection->id);
            } else {
                $this->message('validation');
            }
        }
        $this->saveReferer();
        $this->render('edit');
    }

    public function edit($id = null)
    {
        if (!empty($this->data)) {
            if (!$id) {
                $this->ImageCollection->create(); // 2nd pass
            }
            // Try to save data, if it fails, retry
            if ($this->ImageCollection->save($this->data)) {
                $this->Session->setFlash(
                    sprintf(__('The %s has been saved.', true), __d('uploads', 'Image collection', true)),
                    'success'
                );
                $this->xredirect();
            } else {
                $this->Session->setFlash(
                    sprintf(
                        __('The %s could not be saved. Please, try again.', true),
                        __d('uploads', 'Image collection', true)
                    ),
                    'warning'
                );
            }
        }
        if (empty($this->data)) { // 1st pass
            if ($id) {
                $fields = null;
                $this->ImageCollection->contain('Image');
                if (!($this->data = $this->ImageCollection->read($fields, $id))) {
                    $this->Session->setFlash(__('Invalid Image Collection', true), 'alert');
                    $this->xredirect(); // forget stored referer and redirect
                }
            }
            $this->saveReferer(); // Store actual referer to use in 2nd pass
        }
    }

    public function delete($id = null)
    {
        if (!$this->ImageCollection->delete($id)) {
            $this->Session->setFlash(
                sprintf(__('%s was not deleted.', true), __d('uploads', 'Image collection', true)),
                'alert'
            );
            $this->redirect($this->referer());
        }
        $this->Session->setFlash(
            sprintf(__('%s was deleted.', true), __d('uploads', 'Image collection', true)),
            'success'
        );
        $this->redirect($this->referer());
    }

    /**
     * Returns data to display a collection element.
     *
     * @param string $slug
     */
    public function collection($slug = null)
    {
        $this->ImageCollection->contain('Image');
        $result = $this->ImageCollection->find('first', array(
            'conditions' => array('slug' => $slug),
        ));
        $this->autoRender = false;
        return $this->render('plugins/images/collections/collection.twig', [
            'collection' => $result['ImageCollection'],
            'images' => $result['Image'],
        ]);
    }
}
