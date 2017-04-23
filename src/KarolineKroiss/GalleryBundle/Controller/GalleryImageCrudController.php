<?php

namespace KarolineKroiss\GalleryBundle\Controller;

use KarolineKroiss\GalleryBundle\Entity\GalleryImage;
use KarolineKroiss\GalleryBundle\Entity\GalleryImageRepository;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class GalleryImageCrudController extends CRUDController
{

    public function resizeAction()
    {
        die('Hundnase');
    }

    public function cropAction(Request $request)
    {
        $imageId = $request->request->get('imageId');
        /* @var $galleryImage GalleryImage */
        $galleryImage = $this->getDoctrine()->getRepository('KarolineKroissGalleryBundle:GalleryImage')->findOneBy(['id' => $imageId]);

        $targetWidth = 65;
        $targetHeight = 65;

        $quality = 100;
        $src = $galleryImage->getAbsolutePath();
        $src = $galleryImage->getUploadRootDir() . '/../../' . $galleryImage->getPreviewPath();
        $dst = $galleryImage->getUploadRootDir() . '/../../' . $galleryImage->getThumbnailPath();

        $type = strtolower(substr(strrchr($src, '.'), 1));

        if ($type == 'jpeg') {
            $type = 'jpg';
        }

        switch ($type) {
            case 'bmp':
                $imageResource = imagecreatefromwbmp($src);
                break;
            case 'gif':
                $imageResource = imagecreatefromgif($src);
                break;
            case 'jpg':
                $imageResource = imagecreatefromjpeg($src);
                break;
            case 'png':
                $imageResource = imagecreatefrompng($src);
                break;
            default :
                return 'Unsupported picture type!';
        }

        $destinationResource = imagecreatetruecolor($targetWidth, $targetHeight);

        imagecopyresampled(
            $destinationResource,
            $imageResource,
            0,
            0,
            $request->request->get('x'),
            $request->request->get('y'),
            $targetWidth,
            $targetHeight,
            $request->request->get('w'),
            $request->request->get('h')
        );

        // preserve transparency
        if ($type == 'gif' or $type == 'png') {
            imagecolortransparent($destinationResource, imagecolorallocatealpha($destinationResource, 0, 0, 0, 127));
            imagealphablending($destinationResource, false);
            imagesavealpha($destinationResource, true);
        }

        switch ($type) {
            case 'bmp':
                imagewbmp($destinationResource, $dst);
                break;
            case 'gif':
                imagegif($destinationResource, $dst);
                break;
            case 'jpg':
                imagejpeg($destinationResource, $dst);
                break;
            case 'png':
                imagepng($destinationResource, $dst);
                break;
        }

        $request->headers->get('referer');

        return new RedirectResponse($request->headers->get('referer'));
    }
}
