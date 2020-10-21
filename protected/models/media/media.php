<?php
/**
 * Class For Imageboard Media
 */
class Media extends ModelCore
{
    public function upload(?string $directory = null): ?MediaValuesObject
    {
        $uploadPlugin = $this->getPlugin('upload');
        $imagePlugin  = $this->getPlugin('image');

        $mediaVO = $this->getVO();

        if (empty($directory)) {
            return null;
        }

        $mediaVO->setDirectory($directory);

        $directoryPath = sprintf(
            '%s/%s',
            MediaValuesObject::MEDIA_DIR_PATH,
            $directory
        );

        $uploadPlugin->upload(
            MediaValuesObject::ALLOWED_EXTENSIONS,
            MediaValuesObject::ALLOWED_SIZE,
            MediaValuesObject::INPUT_FILE_NAME
        );

        if (!empty($uploadPlugin->getError())) {
            throw new Exception($uploadPlugin->getError());
        }

        $inputFiles = $uploadPlugin->getFiles();

        if (
            !array_key_exists(MediaValuesObject::INPUT_FILE_NAME, $inputFiles)
        ) {
            return null;
        }

        $inputFiles = $inputFiles[MediaValuesObject::INPUT_FILE_NAME];

        if (empty($inputFiles)) {
            return null;
        }

        $inputFilePath = array_shift($inputFiles);

        $fileName = explode('/', $inputFilePath);
        $fileName = end($fileName);

        $fileExtension = preg_replace(
            '/^(.*?)\.([a-z]+)$/su',
            '$2',
            $fileName
        );

        $type = $this->_getTypeByExtensions($fileExtension);

        if (empty($type)) {
            return null;
        }

        $mediaVO->setFileName($fileName);
        $mediaVO->setType($type);

        if (
            $type == MediaValuesObject::TYPE_IMAGE ||
            $type == MediaValuesObject::TYPE_GIF
        ) {
            $imagePlugin->resize(
                $inputFilePath,
                $directoryPath,
                MediaValuesObject::IMAGE_FILE_NAME,
                MediaValuesObject::IMAGE_FILE_EXTENSION,
                MediaValuesObject::IMAGE_SIZES
            );
        }

        if ($type == MediaValuesObject::TYPE_GIF) {
            $gifFilePath = sprintf(
                '%s/%s-full.gif',
                $directoryPath,
                MediaValuesObject::IMAGE_FILE_NAME
            );

            copy($inputFilePath, $gifFilePath);
            chmod($gifFilePath, 0775);
        }

        return $mediaVO;
    }

    private function _getTypeByExtensions(
        ?string $fileExtension = null
    ): ?string
    {
        if (in_array($fileExtension, MediaValuesObject::IMAGE_EXTENSIONS)) {
            return MediaValuesObject::TYPE_IMAGE;
        }

        if ($fileExtension == MediaValuesObject::GIF_EXTENSION) {
            return MediaValuesObject::TYPE_GIF;
        }

        return null;
    }
}
