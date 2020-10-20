<?php
/**
 * Class For Imageboard Sections
 */
class Section extends ModelCore
{
    public function getVOBySlug(?string $slug = null): ?SectionValuesObject
    {
        if (empty($slug)) {
            return null;
        }

        $row = $this->object->getRowBySlug($slug);

        if (empty($row)) {
            return null;
        }

        return $this->getVO($row);
    }
}
