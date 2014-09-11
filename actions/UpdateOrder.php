<?php
/**
 * Class action used to update orderings on fields
 */
class UpdateOrder extends CAction {

    public function run() {

        $model = Yii::app()->controller->getModel();

        if (!method_exists($model, "getOrderColumn"))
            throw new CHttpException(400, 'To use ordering in MATA, please add a getOrderColumn() method');

        $orderColumn = $model->getOrderColumn();

        if (!is_string($orderColumn))
            throw new CHttpException(500, "OrderColumn needs to be a string");

        if(Yii::app()->request->isPostRequest) {

            $ids = array_map('intval', explode(',', Yii::app()->getRequest()->getParam("reorder-ids")));
            $count = count($ids)-1;
            for ($i=0; $i<$count; $i++) {
                $modelToUpdate = $model->findByPk($ids[$i]);
                if($modelToUpdate) {
                    $modelToUpdate->$orderColumn = $i+1;
                    $modelToUpdate->save();
                }
            }
            echo CJSON::encode(array('status'=>'success'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
}
