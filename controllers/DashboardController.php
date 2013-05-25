<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DashboardController
 *
 * @author wichura
 */
class DashboardController extends MataController {

    public $layout = 'mata.views.layouts.mataModule';

    public function actionIndex() {
        parent::actionIndex();
    }

    public function actionGetUserStatsFromGoogleAnalytics() {

        /**
         * @var apiPlusService $service
         */
        $plus = Yii::app()->googleApis->serviceFactory('Plus');

        /**
         * @var apiClient $client
         */
        $client = Yii::app()->googleApis->client;

        try {
            if (!isset(Yii::app()->session['auth_token']) || is_null(Yii::app()->session['auth_token']))
            // You want to use a persistence layer like the DB for storing this along
            // with the current user
                Yii::app()->session['auth_token'] = $client->authenticate();
            else
                $activities = '';
            $client->setAccessToken(Yii::app()->session['auth_token']);
            $activities = $plus->activities->listActivities('me', 'public');
            print 'Your Activities: <pre>' . print_r($activities, true) . '</pre>';
        } catch (Exception $e) {
            // This needs some love as not every exception means that the token
            // was invalidated
            Yii::app()->session['auth_token'] = null;
            throw $e;
        }
    }

}

?>
