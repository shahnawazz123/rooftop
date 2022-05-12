<?php

namespace app\controllers;
use yii;
use yii\rest\ActiveController;
use app\models\Artist;

class ApiController extends ActiveController
{
	public $modelClass = 'app\models\Artist';
	
    public function actionScheduleCoaches()
    {
    	try {
    		$modelArtist = new Artist();
    		$modelArtist->localTimeZone = 5;
    		Yii::$app->response->format = yii\web\Response:: FORMAT_JSON;
        	return array('status' => true, 'result' => $modelArtist->getCoaches(),'message'=> 'getCoaches');
    	} catch (yii\db\Exception $e) {
            Yii::error($e, 'db_error');
            return array('status' => false,'message'=> $e->getMessage());
        } catch (\Exception $e) {
            Yii::error($e, 'app_error');
            return array('status' => false,'message'=> $e->getMessage());
        } catch (\yii\db\IntegrityException $e) {
            Yii::error($e, 'db_error');
            return array('status' => false,'message'=> $e->getMessage());
        }catch (\yii\base\ErrorException $e) {
            return array('status' => false, 'message'=> 'Error occured');
        }
    }

    public function actionCurrentCoaches()
    {
    	try {
    		$modelArtist = new Artist();
    		$modelArtist->localTimeZone = 5;
            $msg = 'Successfull';
            date_default_timezone_set('Asia/Kolkata');
    		$records = [];$day = date("l");$current_time =  date('H:i:s');
    		foreach ($modelArtist->getCoaches($day) as $key => $coach) {
    			if (strtotime($current_time) < strtotime($coach->available_at)) {
    				$records[] = [
    					'id' => $coach->id,
    					'name' => $coach->name,
    					'timezone' => $coach->timezone,
    					'day_of_week' => $coach->day_of_week,
    					'available_at' => $coach->available_at,
    					'available_until' => $coach->available_until
    				];
    			}else{
                    $msg = 'No result found.';
                }
    		}
    		Yii::$app->response->format = yii\web\Response:: FORMAT_JSON;
        	return array('status' => true, 'result' => $records,'message'=> $msg);
    	} catch (yii\db\Exception $e) {
            Yii::error($e, 'db_error');
            return array('status' => false,'message'=> $e->getMessage());
        } catch (\Exception $e) {
            Yii::error($e, 'app_error');
            return array('status' => false,'message'=> $e->getMessage());
        } catch (\yii\db\IntegrityException $e) {
            Yii::error($e, 'db_error');
            return array('status' => false,'message'=> $e->getMessage());
        }catch (\yii\base\ErrorException $e) {
            return array('status' => false, 'message'=> 'Error occured');
        }
    }

    public function actionAvailableCoaches($available_time)
    {
    	try {
            if (!is_numeric(strtotime($available_time))) {
                throw new \Exception("Invalid parameter value");
            }
    		$modelArtist = new Artist();
    		$modelArtist->localTimeZone = 5;
    		Yii::$app->response->format = yii\web\Response:: FORMAT_JSON;
    		$records = [];
    		foreach ($modelArtist->getCoaches() as $key => $coach) {
    			if (strtotime($available_time) < strtotime($coach->available_at)) {
    				$records[] = [
    					'id' => $coach->id,
    					'name' => $coach->name,
    					'timezone' => $coach->timezone,
    					'day_of_week' => $coach->day_of_week,
    					'available_at' => $coach->available_at,
    					'available_until' => $coach->available_until
    				];
    			}
    		}
        	return array('status' => true, 'result' => $records,'message'=> 'getCoaches');
    	} catch (yii\db\Exception $e) {
            Yii::error($e, 'db_error');
            return array('status' => false,'message'=> $e->getMessage());
        } catch (\Exception $e) {
            Yii::error($e, 'app_error');
            return array('status' => false,'message'=> $e->getMessage());
        } catch (\yii\db\IntegrityException $e) {
            Yii::error($e, 'db_error');
            return array('status' => false,'message'=> $e->getMessage());
        }catch (\yii\base\ErrorException $e) {
            return array('status' => false, 'message'=> 'Error occured');
        }
    }

}
