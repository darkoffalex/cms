<?php
class FilesController extends Controller
{


    /**
     * Force download file
     * @param $id
     * @param int $zip
     * @throws CHttpException
     */
    public function actionGetFile($id, $zip = 0)
    {
        $file = FileEx::model()->findByPk((int)$id);

        if(!empty($file))
        {
            $localPath = $file->getLocalPath();
            $this->file_force_download($localPath,$file->original_filename);
        }
        else
        {
            throw new CHttpException(404);
        }
    }

    /**
     * Push file with headers to client (special helping method)
     * @param $file string
     * @param $name string
     */
    private function file_force_download($file, $name) {
        if (file_exists($file)) {

            if (ob_get_level()) {
                ob_end_clean();
            }

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $name);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));

            readfile($file);
            exit;
        }
    }
}