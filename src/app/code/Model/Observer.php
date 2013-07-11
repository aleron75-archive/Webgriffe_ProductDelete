<?php
class Webgriffe_ProductDelete_Model_Observer
{
    public function onProductDeleteAfter($observer)
    {
        $product = $observer->getEvent()->getProduct();
        if ($product && $product->getId()) {
            Mage::log('Observed a delete after commit on product ' . $product->getId(), null, 'Webgriffe_ProductDelete.log');
            $images = $product->getMediaGallery('images');
            foreach ($images as $image) {
                $imageFile = $product->getMediaConfig()->getMediaPath($image['file']);
                if (@unlink($imageFile)) {
                    Mage::log('Deleted Product Image File "' . $imageFile . '"', null, 'Webgriffe_ProductDelete.log');
                } else {
                    Mage::log('Could not delete Product Image File "' . $imageFile . '"', null, 'Webgriffe_ProductDelete.log');
                }
            }
        }
    }
}