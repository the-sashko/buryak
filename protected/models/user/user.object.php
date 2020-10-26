<?php
class UserObject extends ModelObjectCore
{
    const TABLE_SESSIONS = 'sessions';

    const TABLE_IP_SESSIONS = 'ip2session';

    public $scope = 'users';

    public $ttl = 60 * 30;

    public function updateSessionById(
        ?array $row       = null,
        ?int   $idSession = null
    ): bool
    {
        if (empty($row) && empty($idSession)) {
            return false;
        }

        if (!empty($idSession)) {
            $condition = sprintf('"id" = %d', $idPost);
        }

        return $this->updateRows(static::TABLE_SESSIONS, $row, $condition);
    }

    public function getSesionById(?int $idSession = null): ?array
    {
        if (empty($idSession)) {
            return null;
        }

        $sql = '
            SELECT *
            FROM "%s";
        ';

        $sql = sprintf($sql, static::TABLE_SESSIONS);

        return $this->getRow($sql);
    }

    public function getIpHashByIdSession(?int $idSession = null): ?string
    {
        if (empty($idSession)) {
            return null;
        }

        $sql = '
            SELECT "ip_hash"
            FROM "%s"
            WHERE "id_session" = %d;
        ';

        $sql = sprintf($sql, static::TABLE_IP_SESSIONS, $idSession);

        return $this->getOne($sql);
    }

    public function insertIpHash(
        ?int    $idSession = null,
        ?string $ipHash    = null
    ): bool
    {
        if (empty($idSession) || empty($ipHash)) {
            return false;
        }

        $row = [
            'id_session' => $idSession,
            'ip_hash'    => $ipHash
        ];

        return $this->addRow(static::TABLE_IP_SESSIONS, $row);
    }

    public function insertSession(?array $sessionRow = null): bool
    {
        if (empty($sessionRow)) {
            return false;
        }

        return $this->addRow(static::TABLE_SESSIONS, $sessionRow);
    }

    public function getIdSessionByIpHash(?string $ipHash = null): ?int
    {
        if (empty($ipHash)) {
            return null;
        }

        $sql = '
            SELECT "id_session"
            FROM "%s"
            WHERE "ip_hash" = \'%s\';
        ';

        $sql = sprintf($sql, static::TABLE_IP_SESSIONS, $ipHash);

        return (int) $this->getOne($sql);
    }

    public function getSessionMaxId(): int
    {
        $sql = '
            SELECT
                MAX("id")
            FROM "%s";
        ';

        $sql = sprintf($sql, static::TABLE_SESSIONS);

        return (int) $this->getOne($sql);
    }
}
