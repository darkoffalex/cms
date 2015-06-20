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
            array('images', 'file', 'types'=>'jpg, gif, png', 'allowEmpty' => true, 'maxFiles' => 10, 'maxSize' => 4000000),
            array('image', 'file', 'types'=>'jpg, gif, png', 'allowEmpty' => true, 'maxSize' => 4000000),
            array('files', 'file', 'types'=>'swf, pdf, txt, zip, mp3, jpg, gif, png, pdf, wav, avi, doc, xls', 'allowEmpty' => true, 'maxFiles' => 10, 'maxSize' => 9000000),
            array('file', 'file', 'types'=>'swf, pdf, txt, zip, mp3, jpg, gif, png, pdf, wav, avi, doc, xls', 'allowEmpty' => true, 'maxSize' => 9000000),
        );
    }

}
