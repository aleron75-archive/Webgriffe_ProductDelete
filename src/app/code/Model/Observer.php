<?php
class Webgriffe_ProductDelete_Model_Observer
{
    public function onProductDeleteAfter($observer)
    {
        $product = $observer->getEvent()->getDataObject();
        Mage::log('Observed a delete after commit on product ' . $product->getId(), null, 'Webgriffe_ProductDelete.log');
        if ($product->getId()) {
            $images = $product->getMediaGallery('images');
            foreach ($images as $image) {
                $imageFile = Mage::getBaseDir('media').DS.'catalog'.DS.'product'.$image['file'];
                if (@unlink($imageFile)) {
                    Mage::log('Deleted Product Image File "' . $imageFile . '"', null, 'Webgriffe_ProductDelete.log');
                } else {
                    Mage::log('Could not deleted Product Image File "' . $imageFile . '"', null, 'Webgriffe_ProductDelete.log');
                }
            }
        }
    }
}