<?php
class SectionObject extends ModelObjectCore
{
    const TABLE_SECTIONS = 'sections';

    public $scope = 'section';

    public $ttl = 60 * 60 * 12;

    public function getRowBySlug(?string $slug = null): ?array
    {
        if (empty($slug)) {
            return null;
        }

        $sql = '
            SELECT *
            FROM "%s"
            WHERE "slug" = \'%s\';
        ';

        $sql = sprintf($sql, static::TABLE_SECTIONS, $slug);

        $row = $this->getRow($sql);

        if (empty($row)) {
            return null;
        }

        return $row;
    }
}
