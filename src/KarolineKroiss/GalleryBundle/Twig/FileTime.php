<?php

/**
 * Copyright © 2017-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace KarolineKroiss\GalleryBundle\Twig;

class FileTime extends \Twig_Extension
{

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('file', array($this, 'fileFilter')),
        );
    }

    /**
     * @param $filePath
     *
     * @return mixed
     */
    public function fileFilter($filePath)
    {
        $changeDate = @filemtime($_SERVER['DOCUMENT_ROOT'] . '/' . $filePath);
        if (!$changeDate) {
            $changeDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        }

        return $filePath . '?' . $changeDate;
    }

}
