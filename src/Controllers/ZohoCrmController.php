<?php


namespace dayscript\laravelZohoCrm\Controllers;

require '/home/ariel/projects/laravel-packages/laravel_zoho_crm/packages/dayscript/laravelZohoCrm/vendor/autoload.php';

use App\Http\Controllers\Controller;
use dayscript\laravelZohoCrm\laravelZohoCrm;


use ZCRMRestClient;
use ZohoOAuth;
use ZCRMModule;
use ZCRMRecord;
use ZCRMInventoryLineItem;
use ZCRMTax;
use ZCRMOrganization;

class ZohoCrmController extends Controller {

    public function getOrg(){
      $zoho = new laravelZohoCrm;
      $zoho->getOrg();
      return $zoho;
    }

    public function getModule($module) {
      $zoho = new laravelZohoCrm;
      $zoho->getModuleRecords($module);
      return $zoho;

    }

    public function addModuleRecord($module){
      $zoho = new LaravelZohoCrm;
      $recordsArray = array([
        "Company" => "Afar INC",
        "Email" => "myafarinc@gmail.com",
        "Description" => null,
        "Rating" => null,
        "Website" => null,
        "Twitter" => null,
        "Salutation" => "Sr.",
        "First_Name" => "Ariel",
        "Lead_Status" => null,
        "Industry" => null,
        "Full_Name" => "Sr. Ariel Acevedo",
        "Record_Image" => null,
        "Skype_ID" => null,
        "Phone" => "3167490905",
        "Street" => null,
        "Zip_Code" => null,
        "Email_Opt_Out" => false,
        "Designation" => "Desarrollador",
        "City" => null,
        "No_of_Employees" => null,
        "Mobile" => null,
        "Prediction_Score" => null,
        "Last_Name" => "Acevedo",
        "State" => null,
        "Lead_Source" => null,
        "Country" => null,
        "Tag" => [],
        "Fax" => null,
        "Annual_Revenue" => null,
        "Secondary_Email" => null
      ]);

      $zoho->addModuleRecord($module,$recordsArray);
      return $zoho;
    }

    public function getModuleRecord($module, $entity_id){
      $zoho = new laravelZohoCrm();
      $zoho->getModuleRecord($module, $entity_id);
      return $zoho;
    }


    public function login(){
      return new laravelZohoCrm;
    }

}