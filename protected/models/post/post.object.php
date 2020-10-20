<?php
class PostObject extends ModelObjectCore
{
    const TABLE_POSTS = 'posts';

    public $scope = 'posts';

    public $ttl = 60 * 30;

    public function insertPost(?array $row = null): bool
    {
        return $this->addRow(static::TABLE_POSTS, $row);
    }

    public function updatePostById(?array $row = null, ?int $idPost = null): bool
    {
        $condition = null;

        if (!empty($idPost)) {
            $condition = sprintf('"id" = %d', $idPost);
        }

        return $this->updateRows(static::TABLE_POSTS, $row, $condition);
    }

    public function getMaxId(): int
    {
        $sql = '
            SELECT
                MAX("id")
            FROM "%s";
        ';

        $sql = sprintf($sql, static::TABLE_POSTS);

        return (int) $this->getOne($sql);
    }

    public function getMaxRelativeCode(int $idSection): int
    {
        $sql = '
            SELECT
                MAX("relative_code")
            FROM "%s"
            WHERE "id_section" = %d;
        ';

        $sql = sprintf($sql, static::TABLE_POSTS, $idSection);

        return (int) $this->getOne($sql);
    }
}
