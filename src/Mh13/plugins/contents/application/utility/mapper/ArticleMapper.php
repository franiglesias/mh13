<?php

namespace Mh13\plugins\contents\application\utility\mapper;

class ArticleMapper
{
    public function fromDbToView($data)
    {
        if ($this->isResultSet($data)) {
            foreach ($data as $record) {
                $result[] = $this->mapRecord($record);
            }

            return $result;
        } else {
            return $this->mapRecord($data);
        }

    }

    private function isResultSet($data)
    {
        return is_numeric(key($data));
    }

    /**
     * @param $data
     * @param $result
     *
     * @return mixed
     */
    private function mapRecord($record)
    {

        foreach ($record as $key => $value) {
            list($model, $field) = explode('_', $key);
            $result[$model][$field] = $value;
        }

        return $result;
    }

    public function mapToViewModel($data, $model)
    {
        foreach ($data as $key => $datum) {

            $method = 'set'.ucfirst($key);

            $model->$method($datum);

        }

        return $model;
    }

}
