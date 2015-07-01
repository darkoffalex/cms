<?php
/**
 * Class MediaUploadForm
 * @property CUploadedFile $image
 * @property CUploadedFile $file
 * @property CUploadedFile[] $images
 * @property CUploadedFile[] $files
 */
class MediaUploadForm extends CFormModel
{
    public $images;
    public $image;
    public $files;
    public $file;

    public function rules()
    {
        return array(
            array('images', 'file', 'types'=>Constants::UPLOAD_VALIDATE_IMAGE_TYPES, 'allowEmpty' => true, 'maxFiles' => 10, 'maxSize' => Constants::UPLOAD_IMAGE_FILE_SIZE),
            array('image', 'file', 'types'=>Constants::UPLOAD_VALIDATE_IMAGE_TYPES, 'allowEmpty' => true, 'maxSize' => Constants::UPLOAD_IMAGE_FILE_SIZE),
            array('files', 'file', 'types'=>Constants::UPLOAD_VALIDATE_COMMON_TYPES, 'allowEmpty' => true, 'maxFiles' => 10, 'maxSize' => Constants::UPLOAD_COMMON_FILE_SIZE),
            array('file', 'file', 'types'=>Constants::UPLOAD_VALIDATE_COMMON_TYPES, 'allowEmpty' => true, 'maxSize' => Constants::UPLOAD_COMMON_FILE_SIZE),
        );
    }

}
