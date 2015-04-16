<?php

/**
 * Description of BootsSliderImage
 *
 * @author rnest
 */
class Zend_View_Helper_BootsSliderArticles extends Zend_View_Helper_Abstract
{

    public function bootsSliderArticles($source = null, $id = null, $count = null, $class = 'col-sm-12')
    {
        if (null === $id) {
            $id = uniqid();
        }

        if ($count === null) {
            $count = 10;
        }

        if (null === $source) {
            $model = new CloutWork_Model_Articles();
            $articles = $model->getArticlesForSlider($count);
        } else {
            $articles = $source;
        }

        return $this->view->partial('app-partials/sliderArticles.phtml', null, array(
                    'articles' => $articles,
                    'id' => $id,
                    'class' => $class
        ));
    }

}
