<?php

namespace KarolineKroiss\GalleryBundle\Controller;

use KarolineKroiss\GalleryBundle\Entity\GalleryImage;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Exception;

class GalleryImageCrudController extends CRUDController
{

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Exception
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function cropAction(Request $request)
    {
        $imageId = $request->request->get('imageId');
        /* @var $galleryImage GalleryImage */
        $galleryImage = $this->getDoctrine()->getRepository('KarolineKroissGalleryBundle:GalleryImage')->findOneBy(['id' => $imageId]);

        $targetWidth = 65;
        $targetHeight = 65;

        $source = $galleryImage->getAbsolutePreviewPath();
        $destination = $galleryImage->getAbsoluteThumbnailPath();

        $extension = pathinfo($source)['extension'];

        if ($extension == 'jpeg') {
            $extension = 'jpg';
        }

        switch ($extension) {
            case 'bmp':
                $imageResource = imagecreatefromwbmp($source);
                break;
            case 'gif':
                $imageResource = imagecreatefromgif($source);
                break;
            case 'jpg':
                $imageResource = imagecreatefromjpeg($source);
                break;
            case 'png':
                $imageResource = imagecreatefrompng($source);
                break;
            default :
                return 'Unsupported extension of your file!';
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
        if ($extension == 'gif' or $extension == 'png') {
            imagecolortransparent($destinationResource, imagecolorallocatealpha($destinationResource, 0, 0, 0, 127));
            imagealphablending($destinationResource, false);
            imagesavealpha($destinationResource, true);
        }

        $result = false;

        if (is_file($destination)) {
            unlink($destination);
        }

        switch ($extension) {
            case 'bmp':
                $result = imagewbmp($destinationResource, $destination);
                break;
            case 'gif':
                $result = imagegif($destinationResource, $destination);
                break;
            case 'jpg':
                $result = imagejpeg($destinationResource, $destination);
                break;
            case 'png':
                $result = imagepng($destinationResource, $destination);
                break;
        }

        if (!$result) {
            throw new Exception(sprintf('Image "%s" could not be created!', $destination));
        }

        return new RedirectResponse($request->headers->get('referer'));
    }
}
