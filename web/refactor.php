<?php

require __DIR__ . '/../vendor/autoload.php';

use Cocur\Slugify\Slugify;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

$galleryRootDir = __DIR__ . DIRECTORY_SEPARATOR . 'gallery';
$finder = new Finder();

$filesystem = new Filesystem();
foreach ($finder->files()->in($galleryRootDir) as $file)
{
    $fileName = $file->getFilename();

    $pathParts = pathinfo($fileName);
    $slugify = new Slugify();
    $fileName = $slugify->slugify($pathParts['filename']);

    $newFileName = $fileName . '.' . strtolower($pathParts['extension']);

    $copyDir = $galleryRootDir . DIRECTORY_SEPARATOR;
    if (strpos($file->getPathName(), 'preview')) {
        $copyDir .= 'preview' . DIRECTORY_SEPARATOR;
    }
    if (strpos($file->getPathName(), 'thumbnail')) {
        $copyDir .= 'thumbnail' . DIRECTORY_SEPARATOR;
    }

    if (!is_dir($copyDir)) {
        mkdir($copyDir, 0777, true);
    }
    $copyTo = $copyDir . $newFileName;

    $filesystem->copy($file->getPathName(), $copyTo);
}
