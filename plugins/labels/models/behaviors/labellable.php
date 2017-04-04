<?php
/**
 * Labellable Model Behavior
 *
 * [Short Description]
 *
 * @package   default
 * @author    Fran Iglesias
 * @version   $Id$
 * @copyright Fran Iglesias
 **/
App::import('Model', 'Labels.Labelled');


class LabellableBehavior extends ModelBehavior
{

    /**
     * Contains configuration settings for use with individual model objects.
     * Individual model settings should be stored as an associative array,
     * keyed off of the model name.
     *
     * @var array
     * @access public
     * @see    Model::$alias
     */
    var $settings = array();
    public $Labelled;

    /**
     * LabellableBehavior constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->Labelled = ClassRegistry::init('Labelled');
    }


    /**
     * Initiate Labellable Behavior
     *
     * @param object $model
     * @param array  $config
     *
     * @return void
     * @access public
     */
    function setup(&$model, $config = array())
    {
        $this->Labelled = ClassRegistry::init('Labelled');
    }

    /**
     * After save callback
     *
     * @param object  $model   Model using this behavior
     * @param boolean $created True if this save created a new record
     *
     * @access public
     * @return boolean True if the operation succeeded, false otherwise
     */
    function afterSave(&$model, $created)
    {
        $this->updateLabels($model);
    }

    private function updateLabels($model)
    {
        if ($this->invalidModel($model)) {
            return false;
        }
        $labels = $this->getLabelsList($model);
        if (empty($labels)) {
            return false;
        }
        $this->Labelled->deleteAll(array('model' => $model->alias, 'foreign_key' => $model->getID()));
        foreach ($labels as $label_id) {
            $this->Labelled->create();
            $this->Labelled->save($this->buildRecord($model, $label_id));
        }
        $message = sprintf('Model: %s with fk: %s', $model->alias, $model->getID());
        file_put_contents(LOGS.'labels.log', date('Y-m-d H:i > ').$message.chr(10), FILE_APPEND);
        $message = implode(', ', $this->getLabelsList($model));
        file_put_contents(LOGS.'labels.log', date('Y-m-d H:i > ').$message.chr(10), FILE_APPEND);

        return true;
    }

    private function invalidModel($model)
    {
        if (!$model->alias || !$model->getID()) {
            return true;
        }

        return false;
    }

    private function getLabelsList($model)
    {
        $labels = array();
        if (!empty($model->data['Label']['Global'])) {
            $labels = $model->data['Label']['Global'];
        }
        if (!empty($model->data['Label']['Model'])) {
            $labels = array_merge($labels, $model->data['Label']['Model']);
        }

        return $labels;
    }

    private function buildRecord($model, $label_id)
    {
        return array(
            'Labelled' => array(
                'label_id' => $label_id,
                'model' => $model->alias,
                'foreign_key' => $model->getID(),
            ),
        );
    }

    public function findLabels($model, $options = array())
    {
        $fields = array('Label.id', 'Label.title', 'COUNT(Label.id) as weight');
        $joins = array(
            $this->joinModel($model),
            $this->joinLabels(),
        );
        $group = array('Label.id');
        $order = array('Label.title' => 'asc');
        if (isset($options['joins'])) {
            $joins = array_merge($joins, $options['joins']);
            unset($options['joins']);
        }

        return $this->normalizeWeightField(
            $this->Labelled->find(
                'all',
                array_merge(
                    compact('fields', 'conditions', 'group', 'order', 'joins'),
                    $options
                )
            )
        );
    }

    private function joinModel($model)
    {
        return array(
            'table' => $model->useTable,
            'alias' => $model->alias,
            'type' => 'left',
            'conditions' => array(
                'Labelled.model' => $model->alias,
                'Labelled.foreign_key ='.$model->alias.'.id',
            ),
        );
    }

    private function joinLabels()
    {
        return array(
            'table' => 'labels',
            'alias' => 'Label',
            'type' => 'left',
            'conditions' => array(
                'Labelled.label_id = Label.id',
            ),
        );
    }

    private function normalizeWeightField($records)
    {
        if (!$records) {
            return false;
        }

        return array_map(
            function ($item) {
                $item['Label']['weight'] = $item[0]['weight'];

                return $item;
            },
            array_filter(
                $records,
                function ($item) {
                    return $item[0]['weight'] > 0;
                }
            )
        );
    }
}
