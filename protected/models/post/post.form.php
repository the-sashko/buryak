<?php
class PostForm extends FormObject
{
    const ERROR_INPUT_DATA_NOT_SET = 'Input Data Is Not Set';

    const ERROR_TEXT_OR_MEDIA_IS_NOT_SET = '';

    const ERROR_MEDIA_IS_NOT_SET = '';

    const ERROR_INVALID_MEDIA_FILE = '';

    const ERROR_CAPTCHA_TEXT_IS_NOT_SET = 'Captcha Text Is Not Set';

    const ERROR_SECTION_IS_NOT_SET = 'Section Value Is Not Set';

    const REDIRECT_TO_THREAD = 'thread';

    const REDIRECT_TO_SECTION = 'section';

    public function checkInputParams(): bool
    {
        if (empty($this->data)) {
            $this->setError(static::ERROR_INPUT_DATA_NOT_SET);

            return false;
        }

        $this->setSuccess();

        $this->_checkText();
        $this->_checkSection();

        if ($this->getThreadId() < 1) {
            $this->_checkCaptchaText();
        }

        return $this->getStatus();
    }

    public function getTitle(): ?string
    {
        if (!$this->has('title')) {
            return null;
        }

        return $this->get('title');
    }

    public function getText(): ?string
    {
        if (!$this->has('text')) {
            return null;
        }

        return $this->get('text');
    }

    public function getName(): ?string
    {
        if (!$this->has('name')) {
            return null;
        }

        return $this->get('name');
    }

    public function getPassword(): ?string
    {
        if (!$this->has('password')) {
            return null;
        }

        return $this->get('password');
    }

    public function getCaptchaText(): ?string
    {
        if (!$this->has('captcha_text')) {
            return null;
        }

        return $this->get('captcha_text');
    }

    public function getRedirectTo(): ?string
    {
        if (!$this->has('redirect_to')) {
            return null;
        }

        return $this->get('redirect_to');
    }

    public function getThreadId(): int
    {
        if (!$this->has('thread_id')) {
            return null;
        }

        return (int) $this->get('thread_id');
    }

    public function getSection(): ?string
    {
        if (!$this->has('section')) {
            return null;
        }

        return $this->get('section');
    }

    public function getSectionUrl(): ?string
    {
        if (!$this->has('section_url')) {
            return null;
        }

        return $this->get('section_url');
    }

    public function setTitle(?string $title = null): bool
    {
        return $this->set('title', $title);
    }

    public function setText(?string $text = null): bool
    {
        return $this->set('text', $text);
    }

    public function setName(?string $name = null): bool
    {
        return $this->set('name', $name);
    }

    public function setPassword(?string $password = null): bool
    {
        return $this->set('password', $password);
    }

    public function setCaptchaText(?string $captchaText = null): bool
    {
        return $this->set('captcha_text', $captchaText);
    }

    public function setRedirectTo(?string $redirectTo = null): bool
    {
        return $this->set('redirect_to', $redirectTo);
    }

    public function setThreadId(int $idThread = null): bool
    {
        return $this->set('thread_id', $idThread);
    }

    public function setSection(?string $section = null): bool
    {
        return $this->set('section', $section);
    }

    public function setSectionUrl(?string $sectionUrl = null): bool
    {
        if (!empty($sectionUrl)) {
            return $this->set('section_url', $sectionUrl);
        }

        $section = $this->getSection();

        if (empty($section)) {
            return $this->set('section_url', '/');
        }

        $sectionUrl = sprintf('/%s/', $section);

        return $this->set('section_url', $sectionUrl);
    }

    private function _checkCaptchaText(): void
    {
        $captchaText = $this->getCaptchaText();

        if (empty($captchaText)) {
            $this->setFail();
            $this->setError(static::ERROR_CAPTCHA_TEXT_IS_NOT_SET);
        }
    }

    private function _checkSection(): void
    {
        $section = $this->getSection();

        if (empty($section)) {
            $this->setFail();
            $this->setError(static::ERROR_SECTION_IS_NOT_SET);
        }
    }
}
