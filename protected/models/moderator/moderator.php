<?php
/**
 * ModelCore Class For Example Model
 */
class Example extends ModelCore
{
    /**
     * Get All Example Data
     *
     * @return array List Of Example Data
     */
    public function getAll(): ?array
    {
        $data = $this->object->getAllExamples();

        return $this->getVOArray($data);
    }
}
