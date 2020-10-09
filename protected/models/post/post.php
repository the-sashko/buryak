<?php
/**
 * Class For Imageboard Posts
 */
class Post extends ModelCore
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
