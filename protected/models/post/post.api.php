<?php
class PostApi extends ModelApiCore
{
    public function actionCreate(): ModelApiResultObject
    {
        $this->result->setSuccess();

        var_dump($this->get); die();

        return $this->result;
    }

    public function actionGet(): ModelApiResultObject
    {
        return $this->result;
    }

    public function actionUpdate(): ModelApiResultObject
    {
        return $this->result;
    }

    public function actionDelete(): ModelApiResultObject
    {
        return $this->result;
    }
}
