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

    public function getSectionSlug(): ?string
    {
        if (!$this->has('section')) {
            return null;
        }

        return $this->get('section');
    }

    public function getUsername(): ?string
    {
        if (!$this->has('username')) {
            return null;
        }

        return $this->get('username');
    }

    public function isWithoutMedia(): bool
    {
        return $this->has('without_media');
    }

    public function isGenerateTripCode(): bool
    {
        return $this->has('trip_code');
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
        $sectionSlug = $this->getSectionSlug();

        if (empty($sectionSlug)) {
            $this->setFail();
            $this->setError(static::ERROR_SECTION_IS_NOT_SET);
        }
    }
}
