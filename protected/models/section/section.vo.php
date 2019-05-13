<?php
/**
 * ValuesObject Class For Section Model
 */
class SectionVO extends ValuesObject
{
    /**
     * @var string Active Status
     */
    const STATUS_ACTIVE = 'active'; 

    /**
    * @var string Closed Status
    */
    const STATUC_CLOSED = 'closed';

    /**
    * @var string Hidden Status
    */
    const STATUC_HIDDEN = 'hidden';

    /**
     * Get Section ID
     *
     * @return int Section ID
     */
    public function getID() : int
    {
        return (int) $this->get('id');
    }

    /**
     * Get Section Slug
     *
     * @return string Section Slug
     */
    public function getSlug() : string
    {
        return (string) $this->get('slug');
    }

    /**
     * Get Section Title
     *
     * @return string Section Title
     */
    public function getTitle() : string
    {
        return (string) $this->get('title');
    }

    /**
     * Get Section Description
     *
     * @return string Section Description
     */
    public function getDescription() : string
    {
        return (string) $this->get('desription');
    }

    /**
     * Get Age Restriction
     *
     * @return int Age Restriction
     */
    public function getAgeRestriction() : int
    {
        return (int) $this->get('age_restriction');
    }

    /**
     * Get Section Status
     *
     * @return string Section Status
     */
    public function getStatus() : string
    {
        return (string) $this->get('status');
    }

    /**
     * Get Section Sort Value
     *
     * @return int Section Sort Value
     */
    public function getSort() : int
    {
        return (int) $this->get('sort');
    }

    /**
     * Set Section Slug
     *
     * @param string $slug Section Slug
     */
    public function setSlug(string $slug = '') : void
    {
        $this->set('slug', $slug);
    }

    /**
     * Set Section Title
     *
     * @param string $title Section Title
     */
    public function setTitle(string $title = '') : void
    {
        $this->set('title', $title);
    }

    /**
     * Set Section Description
     *
     * @param string $description Section Description
     */
    public function setDescription(string $description = '') : void
    {
        $this->set('desription', $description);
    }

    /**
     * Set Section Age Restriction
     *
     * @param int $ageRestriction Section Age Restriction
     */
    public function setAgeRestriction(int $ageRestriction = 0) : void
    {
        $this->set('age_restriction', $ageRestriction);
    }

    /**
     * Set Section Status
     *
     * @param string $status Section Status
     */
    public function setStatus(string $status = '') : void
    {
        $this->set('status', $status);
    }

    /**
     * Set Section Status To Active
     */
    public function setStatusActive() : void
    {
        $this->set('status', static::STATUS_ACTIVE);
    }

    /**
     * Set Section Status To Closed
     */
    public function setStatusClosed() : void
    {
        $this->set('status', static::STATUS_CLOSED);
    }

    /**
     * Set Section Status To Hidden
     */
    public function setStatusHidden() : void
    {
        $this->set('status', static::STATUS_HIDDEN);
    }

    /**
     * Set Section Sort Value
     *
     * @param int $sort Section Sort Value
     */
    public function setSort(int $sort = 0) : void
    {
        $this->set('sort', $sort);
    }
}
?>
