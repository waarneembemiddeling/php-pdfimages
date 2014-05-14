<?php
/*
* (c) Waarneembemiddeling.nl
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/ 

namespace Waarneembemiddeling\PdfImages;

use Alchemy\BinaryDriver\AbstractBinary;
use Alchemy\BinaryDriver\Configuration;
use Alchemy\BinaryDriver\ConfigurationInterface;
use Alchemy\BinaryDriver\Exception\ExecutionFailureException;
use Psr\Log\LoggerInterface;
use Waarneembemiddeling\PdfImages\Exception\RuntimeException;

class PdfImages extends AbstractBinary
{
    /**
     * Returns the name of the driver
     *
     * @return string
     */
    public function getName()
    {
        return 'pdfimages';
    }

    /**
     * Extract images from a given pdf
     *
     * @param $inputPdf
     * @param null $destinationRootFolder
     * @return \FilesystemIterator
     * @throws Exception\RuntimeException
     */
    public function extractImages($inputPdf, $destinationRootFolder = null)
    {
        if (false === is_file($inputPdf)) {
            throw new RuntimeException(sprintf('Input file "%s" not found', $inputPdf));
        }

        if (null === $destinationRootFolder) {
            $destinationRootFolder = sys_get_temp_dir();
        }

        if (false === is_dir($destinationRootFolder)) {
            throw new RuntimeException(sprintf('Destination folder "%s" not found', $destinationRootFolder));
        }

        if (false === is_writable($destinationRootFolder)) {
            throw new RuntimeException('Destination folder "%s" is not writable', $destinationRootFolder);
        }

        $destinationFolder = $destinationRootFolder . '/' . uniqid('pdfimages').'/';
        mkdir($destinationFolder);

        try {
            $this->command(array(
                '-j',
                $inputPdf,
                $destinationFolder
            ));
        } catch (ExecutionFailureException $e) {
            throw new RuntimeException('PdfImages was unable to extract images', $e->getCode(), $e);
        }

        return new \FilesystemIterator($destinationFolder, \FilesystemIterator::SKIP_DOTS);
    }


    /**
     * Creates the pdfimages wrapper
     *
     * @param array|ConfigurationInterface $configuration
     * @param LoggerInterface              $logger
     *
     * @return PdfImages
     */
    public static function create($configuration = array(), LoggerInterface $logger = null)
    {
        if (!$configuration instanceof ConfigurationInterface) {
            $configuration = new Configuration($configuration);
        }

        $binaries = $configuration->get('pdfimages.binaries', array('pdfimages'));

        return static::load($binaries, $logger, $configuration);
    }
}
