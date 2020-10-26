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

    public function updatePostById(
        ?array $row    = null,
        ?int   $idPost = null
    ): bool
    {
        if (empty($row) && empty($idPost)) {
            return false;
        }

        $condition = sprintf('"id" = %d', $idPost);

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

    public function getThreadIdByRelativeCode(?int $relativeCode = null): int
    {
        if (empty($relativeCode)) {
            return null;
        }

        $sql = '
            SELECT
                "id"
            FROM "%s"
            WHERE "relative_code" = %d AND "id_parent" IS NULL;
        ';

        $sql = sprintf($sql, static::TABLE_POSTS, $relativeCode);

        return (int) $this->getOne($sql);
    }
}
