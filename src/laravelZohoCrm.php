<?php

namespace dayscript\laravelZohoCrm;

require '/home/ariel/projects/laravel-packages/laravel_zoho_crm/packages/dayscript/laravelZohoCrm/vendor/autoload.php';

use \Illuminate\Database\Eloquent\Model as Eloquent;
use GuzzleHttp\Client;
use ZCRMRestClient;
use ZCRMModule;
use ZohoOAuth;
use ZCRMRecord;
use ZCRMInventoryLineItem;
use ZCRMTax;


class laravelZohoCrm extends Eloquent
{
    // Build wonderful things
    public function __construct(){

      $this->configParams = $this->getConfigParams();

      $_SERVER['user_email_id'] = $this->configParams['client_email'];

      ZCRMRestClient::initialize();
      $oAuthClient = ZohoOAuth::getClientInstance();

      try {
        $oAuthTokens = $oAuthClient->generateAccessToken($this->configParams['grant_token']);
      } catch (\Exception $e) {
        $this->refreshToken = $oAuthClient->getAccessToken($_SERVER['user_email_id']);
      }
    }

    private function getConfigParams(){

      return config('laravelzohocrm');
    }


    public function getLeadsHTTP(){

      $client = new Client(['base_uri' => 'https://www.zohoapis.com/crm/v2/']);
      $headers = array(
          'headers' => [
              'Authorization' => 'Zoho-oauthtoken '.$this->refreshToken
            ]
          );
      $res = $client->request('GET', 'Contacts', $headers);
      return $res->getBody();
    }


    public function getOrg(){

      $zcrmModuleIns = ZCRMRestClient::getInstance();
      $records = $zcrmModuleIns->getOrganizationDetails();
      $this->response = $records->getResponseJSON();
    }

    public function getModuleRecords($module){

      $zcrmModuleIns = ZCRMModule::getInstance($module);
      $records = $zcrmModuleIns->getRecords()->getResponseJSON();
      $this->response = $records;
    }

    public function addModuleRecord($module,$recordsArray){

      $entityResponses = [];
      $date = str_replace(' ','T',date('Y-m-d H:m:s').'-5:00');
      $zcrmModuleIns = ZCRMModule::getInstance($module);

      foreach ($recordsArray as $record_number => $item) {
        $record[$record_number] = ZCRMRecord::getInstance($module,null);

        foreach ($item as $key => $value) {
          $record[$record_number]->setFieldValue($key,$value);
        }

        $record[$record_number]->setCreatedBy(3572287000000181021);
        $record[$record_number]->setCreatedTime($date);
        $record[$record_number]->setModifiedTime($date);

      }
      $bulkAPIResponse = $zcrmModuleIns->createRecords($record); // $recordsArray - array of ZCRMRecord instances filled with required data for creation.
      $entityResponses = $bulkAPIResponse->getEntityResponses();

      $this->response = $entityResponses[0]->getResponseJSON();

    }

    public function getModuleRecord($module, $entity_id){

      $moduleInstance = ZCRMModule::getInstance($module);
      $records = $moduleInstance->getRecord($entity_id);
      $this->response = $records->getResponseJSON();
    }




}