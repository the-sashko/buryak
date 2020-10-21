<?php
/**
 * ValuesObject Class For Media Model
 */
class MediaValuesObject extends ValuesObject
{
    const MEDIA_DIR_PATH = __DIR__.'/../../../files/media';

    const IMAGE_SIZES = [
        'thumbnail' => [
            'height'      => 64,
            'width'       => 64,
            'file_prefix' => 'thumb'
        ],
        'post' => [
            'height'      => null,
            'width'       => 248,
            'file_prefix' => 'p'
        ]
    ];

    const ALLOWED_EXTENSIONS = [
        'jpeg',
        'jpg',
        'gif',
        'png'
    ];

    const ALLOWED_SIZE = 1024*1024*16;

    const INPUT_FILE_NAME = 'media';

    const IMAGE_FILE_NAME = 'image';

    const IMAGE_FILE_EXTENSION = 'png';

    const TYPE_IMAGE = 'image';

    const TYPE_GIF = 'gif';

    const IMAGE_EXTENSIONS = [
        'jpeg',
        'jpg',
        'png'
    ];

    const GIF_EXTENSION = 'gif';

    public function getType(): ?string
    {
        return $this->get('type');
    }

    public function getFileName(): ?string
    {
        return $this->get('file_name');
    }

    public function getDirectory(): ?string
    {
        return $this->get('directory');
    }

    public function getImagePath(?string $size = null): ?string
    {
        if (empty($size)) {
            return null;
        }

        $directory = $this->getDirectory();

        if (empty($directory)) {
            return null;
        }

        if (!array_key_exists($size, static::IMAGE_SIZES)) {
            return null;
        }

        return sprintf(
            '/%s/%s-%s.%s',
            $directory,
            static::IMAGE_FILE_NAME,
            static::IMAGE_SIZES[$size]['file_prefix'],
            static::IMAGE_FILE_EXTENSION
        );
    }

    public function getThumbnailImagePath(): ?string
    {
        return getImagePath('thumbnail');
    }

    public function getPostImagePath(): ?string
    {
        return getImagePath('post');
    }

    public function getFullImagePath(): ?string
    {
        $directory = $this->getDirectory();

        if (empty($directory)) {
            return null;
        }

        $type = $this->getType();

        if (empty($type)) {
            return null;
        }

        if ($type == static::TYPE_GIF) {
            return sprintf(
                '/%s/%s-full.gif',
                $directory,
                static::IMAGE_FILE_NAME
            );
        }

        return sprintf(
            '/%s/%s-full.%s',
            $directory,
            static::IMAGE_FILE_NAME,
            static::IMAGE_FILE_EXTENSION
        );
    }

    public function setType(?string $type = null): void
    {
        $this->set('type', $type);
    }

    public function setFileName(?string $fileName = null): void
    {
        $this->set('file_name', $fileName);
    }

    public function setDirectory(?string $directory = null): void
    {
        $this->set('directory', $directory);
    }
}
