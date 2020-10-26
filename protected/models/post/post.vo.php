<?php
class PostValuesObject extends ValuesObject
{
    const DEFAULT_USERNAME = 'Anonymous';

    public function getId(): int
    {
        return (int) $this->get('id');
    }

    public function getRelativeCode(): int
    {
        return (int) $this->get('relative_code');
    }

    public function getSectionId(): int
    {
        return (int) $this->get('id_section');
    }

    public function getTitle(): ?string
    {
        return $this->get('title');
    }

    public function getText(): ?string
    {
        return $this->get('text');
    }

    public function getUsername(): ?string
    {
        return $this->get('username');
    }

    public function getSessionId(): int
    {
        return (int) $this->set('id_session');
    }

    public function getMediaName(): ?string
    {
        return $this->set('media_name');
    }

    public function getMediaDir(): ?string
    {
        return $this->set('media_dir');
    }

    public function getMediaType(): ?string
    {
        return $this->get('media_type');
    }

    public function getMedia(): ?MediaValuesObject
    {
        return $this->get('media');
    }

    public function getPassword(): ?string
    {
        return $this->get('password');
    }

    public function getTripCode(): ?string
    {
        return $this->get('tripcode');
    }

    public function setRelativeCode(?int $relativeCode = null): void
    {
        $this->set('relative_code', $relativeCode);
    }

    public function setParentId(?int $idParent = null): void
    {
        $this->set('id_parent', $idParent);
    }

    public function setSectionId(?int $idSection = null): void
    {
        $this->set('id_section', $idSection);
    }

    public function setTitle(?string $title = null): void
    {
        $this->set('title', $title);
    }

    public function setText(?string $text = null): void
    {
        $this->set('text', $text);
    }

    public function setUsername(?string $username = null): void
    {
        $this->set('username', $username);
    }

    public function setSessionId(?int $idSession = null): void
    {
        $this->set('id_session', $idSession);
    }

    public function setMediaName(?string $mediaName = null): void
    {
        $this->set('media_name', $mediaName);
    }

    public function setMediaDir(?string $mediaDir = null): void
    {
        $this->set('media_dir', $mediaDir);
    }

    public function setMediaType(?string $mediaType = null): void
    {
        $this->set('media_type', $mediaType);
    }

    public function setMedia(?MediaValuesObject $media = null): void
    {
        $this->set('media', $media);
    }

    public function setPassword(?string $password = null): void
    {
        $this->set('password', $password);
    }

    public function setTripCode(?string $tripcode = null): void
    {
        $this->set('tripcode', $tripcode);
    }
}
