<?php


namespace Engine\Libraries;


class FilesManager
{

    private $publicFtp;
    private $folderContent;
    private $config;
    private $acceptFilesFormat = [];

    public function __construct($scanDir = null)
    {

        $this->config = Helpers::loadFile('config','app');

        $this->acceptFilesFormat = $this->config['accept_files'];
        $this->publicFtp = WWW . $this->config['ftp_folder'];

        if ($scanDir !== null) {
            $this->publicFtp = WWW . $this->config['ftp_folder'] . '/' . $scanDir;
        }

        $this->scanDirectory($this->publicFtp);

    }

    private function scanDirectory($scanDir) {

        $folderContent = scandir( $scanDir, 0);
        $folderContent = array_slice($folderContent, 2);

        if(empty($folderContent)) {
            return $this->folderContent;
        }

        $folders = [];
        $files = [];

        foreach ($folderContent as $key => $item) {

            $mime = pathinfo($this->publicFtp . '/' . $item, PATHINFO_EXTENSION );

            if (is_dir($this->publicFtp . '/' . $item)) {

                $folders[$key] = [
                    'type'      => 'folder',
                    'name'      => $item,
                    'href'      => true
                ];

            } else {
                $files[$key] = [
                    'type'      => 'file',
                    'name'      => $item,
                ];
                if (in_array($mime, $this->acceptFilesFormat)) {
                    $files[$key]['href'] = true;
                }
            }

        }

        $this->folderContent = array_merge($folders, $files);

    }


    public function getContents() {

        return $this->folderContent;

    }

    public function getFile($filename) {

        $file = $this->publicFtp . '/'. $filename;

        return [
            'name'      => $filename,
            'size'      => filesize ( $file ) . ' Byte',
            'hash'      => hash_file($this->config['hash_type'], $file),
            'created'   => date ("d-m-y G:i:s",filectime($file)),
            'content'   => htmlspecialchars(file_get_contents($file))
        ];

    }

}