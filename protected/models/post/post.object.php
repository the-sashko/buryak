<?php
class PostObject extends ModelObjectCore
{
    public $scope = 'posts';

    public function test(): ?array
    {
        var_dump($this->getRows('SELECT \'123\';'));
        die();
    }
}
