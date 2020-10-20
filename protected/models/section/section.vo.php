<?php
class SectionValuesObject extends ValuesObject
{
    public function getId(): int
    {
        return (int) $this->get('id');
    }

    public function getSlug(): ?string
    {
        return $this->get('slug');
    }

    public function getTitle(): ?string
    {
        return $this->get('title');
    }

    public function getDescriptionShort(): ?string
    {
        return $this->get('desription_short');
    }

    public function getDescriptionFull(): ?string
    {
        return $this->get('desription_full');
    }

    public function getAgeRestriction(): ?int
    {
        $ageRestriction = (int) $this->get('age_restriction');

        if (empty($ageRestriction)) {
            return null;
        }

        return $ageRestriction;
    }

    public function getDefaultUsername(): ?string
    {
        return $this->get('default_username');
    }

    public function getSort(): ?int
    {
        $sort = (int) $this->get('sort');

        if (empty($sort)) {
            return null;
        }

        return $sort;
    }

    public function getStatus(): ?string
    {
        return $this->get('status');
    }

    public function setSlug(?string $slug = null): void
    {
        $this->set('slug', $slug);
    }

    public function setTitle(?string $title = null): void
    {
        $this->set('title', $title);
    }

    public function setDescriptionShort(?string $desriptionShort = null): void
    {
        $this->set('desription_short', $desriptionShort);
    }

    public function setDescriptionFull(?string $desriptionFull = null): void
    {
        $this->set('desription_full', $desriptionFull);
    }

    public function setAgeRestriction(?int $ageRestriction = null): void
    {
        $this->set('age_restriction', $ageRestriction);
    }

    public function setSort(?int $sort = null): void
    {
        $this->set('sort', $sort);
    }

    public function setDefaultUsername(?string $defaultUsername = null): void
    {
        $this->set('default_username', $defaultUsername);
    }

    public function setStatus(?string $status = null): void
    {
        $this->set('status', $status);
    }
}
