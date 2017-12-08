<?php

error_reporting(E_ERROR);

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$input = json_decode(file_get_contents('php://input'), true);
$dbName = 'glendor';
$hostName = 'localhost';
$userName = 'root';
$password = 'hercules15';
$parameters = array();

function returnError($error) {
    header("HTTP/1.0 500 Internal Server Error");
    $errorObject = array();
    $errorObject['errorMessage'] = $error;
    $errorObject['returnMessage'] = 'ERROR';
    $errorObject['returnStatus'] = '500';
    echo json_encode($errorObject);
    die;
}

function returnResponse($result) {
    header("HTTP/1.0 200");
    $resultObject = array();
    $resultObject['data'] = $result;
    $resultObject['returnMessage'] = 'OK';
    $resultObject['returnStatus'] = '200';
    echo json_encode($resultObject);
}

function get_userinternalid($dbname, $userExternalId) {
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');

    $sql = "SELECT * FROM users WHERE deleted = 0 AND userExternalId = '" . $userExternalId . "'";
    $res = $mysqli->query($sql);
    $userId = NULL;
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $userId = $row['id'];
            break;
        }
        $res->close();
    }
    $mysqli->close();
    return ($userId);
}

function verify_userexternalid($dbname, $userExternalId) {
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');

    $sql = "SELECT * FROM users WHERE deleted = 0 AND userExternalId = '" . $userExternalId . "'";
    $res = $mysqli->query($sql);
    $flag = false;
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $flag = true;
            break;
        }
        $res->close();
    }
    $mysqli->close();
    return ($flag);
}

function build_db_schema($dbname) {
    echo("Started build_db_schema...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password)
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password']);
// Check connection
    if ($mysqli === false)
        die("ERROR: Could not connect. " . $mysqli->connect_error);
// Attempt to delete database query execution
    $sql = "DROP DATABASE IF EXISTS " . $dbname;
    if ($mysqli->query($sql) === true)
        echo("Database deleted successfully\n");
    else
        echo ("ERROR: unable to execute $sql. " . $mysqli->error . "\n");
// Attempt to create database query execution
    $sql = "CREATE DATABASE " . $dbname;
    if ($mysqli->query($sql) === true)
        echo("Database created successfully\n");
    else
        echo ("ERROR: unable to execute $sql. " . $mysqli->error . "\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        die("ERROR: Could not connect. " . $mysqli->connect_error);
// Attempt create table query execution
// 	====================
//	User Info Tables
// 	====================
//	Users
    $sql = "CREATE TABLE users(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		userType VARCHAR(255) NULL,
		userName VARCHAR(255) NULL,
		userEmail VARCHAR(255) NULL,
		userPassword VARCHAR(255) NULL,				
		userExternalId VARCHAR(255) NULL,			
		userPictFilename VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table USERS created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");
//	Participants
    $sql = "CREATE TABLE participants(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		particType VARCHAR(255) NULL,
		userId INT NULL,
		userName VARCHAR(255) NULL,
		participantName VARCHAR(255) NULL,
		gender VARCHAR(255) NULL,
		age VARCHAR(255) NULL,
		relatToUser VARCHAR(255) NULL,
		particPictFilename VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table PARTICIPANTS created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

//	ParticInsPlans
    $sql = "CREATE TABLE particinsplans(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		insurancePlanType VARCHAR(255) NULL,
		userId INT NULL,
		userName VARCHAR(255) NULL,
		participantId INT NULL,
		participantName VARCHAR(255) NULL,
		particInsurerName VARCHAR(255) NULL,
		particInsPlanName VARCHAR(255) NULL,
		primaryInsPlan INT NULL,
		startDate VARCHAR(255) NULL,
		endDate VARCHAR(255) NULL,
		monthlyPremium VARCHAR(255) NULL,
		deductInNetworkFamily VARCHAR(255) NULL,
		deductInNetworkIndiv VARCHAR(255) NULL,
		deductOutNetworkFamily VARCHAR(255) NULL,
		deductOutNetworkIndiv VARCHAR(255) NULL,
		maxOopInNetworkFamily VARCHAR(255) NULL,
		maxOopInNetworkIndiv VARCHAR(255) NULL,
		maxOopOutNetworkFamily VARCHAR(255) NULL,
		maxOopOutNetworkIndiv VARCHAR(255) NULL,
		deductAppliedToOop INT NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table PARTICINSPLANS created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

//	ParticProviders
    $sql = "CREATE TABLE particproviders(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		providerType VARCHAR(255) NULL,
		userId INT NULL,
		userName VARCHAR(255) NULL,
		participantId INT NULL,
		participantName VARCHAR(255) NULL,
		providerPNI VARCHAR(255) NULL,
		particProviderName VARCHAR(255) NULL,
		providerLastName VARCHAR(255) NULL,
		providerFirstName VARCHAR(255) NULL,
		providerMiddleName VARCHAR(255) NULL,
		providerSpecialty VARCHAR(255) NULL,
		providerAddr VARCHAR(255) NULL,
		providerCountyId INT NULL,
		providerCountyName VARCHAR(255) NULL,
		providerWebsite VARCHAR(255) NULL,
		providerEmail VARCHAR(255) NULL,
		providerPhone VARCHAR(255) NULL,
		providerFax VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";

    if ($mysqli->query($sql) === true)
        echo("Table PROVIDERS created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

//	Docs
    $sql = "CREATE TABLE docs(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		docType VARCHAR(255) NULL,
		docStatusUpload VARCHAR(255) NULL,		
		docStatusReview VARCHAR(255) NULL,		
		docStatusComplete VARCHAR(255) NULL,	
		docStatusNote VARCHAR(255) NULL,		
		userId INT NULL,
		userName VARCHAR(255) NULL,
		participantId INT NULL,
		participantName VARCHAR(255) NULL,
		particInsPlanId INT NULL,
		particInsPlanName VARCHAR(255) NULL,
		docTime INT NULL,
		docAmount VARCHAR(255) NULL,
		indivDeductPaid VARCHAR(255) NULL,
		familyDeductPaid VARCHAR(255) NULL,
		imageFileName VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table DOCS created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

//	DocItems		
    $sql = "CREATE TABLE docitems(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		docItemType VARCHAR(255) NULL,
		docId INT NULL,
		docType VARCHAR(255) NULL,
		userId INT NULL,
		userName VARCHAR(255) NULL,
		participantId INT NULL,
		participantName VARCHAR(255) NULL,
		particInsPlanId INT NULL,
		particInsPlanName VARCHAR(255) NULL,
		providerPNI VARCHAR(255) NULL,
		particProviderId INT NULL,
		particProviderName VARCHAR(255) NULL,
		serviceDate VARCHAR(255) NULL,
		placeOfService VARCHAR(255) NULL,
		codeType VARCHAR(255) NULL,
		code INT NULL,
		codeMod INT NULL,
		codeQty INT NULL,
		codeDescr TEXT NULL,
		codeAltDescr TEXT NULL,
		amountBilled VARCHAR(255) NULL,
		amountExcluded VARCHAR(255) NULL,
		amountAllowed VARCHAR(255) NULL,
		coInsAmount VARCHAR(255) NULL,
		coPayAmount VARCHAR(255) NULL,
		particPaid VARCHAR(255) NULL,
		excluded INT NULL,
		exclusionCode VARCHAR(255) NULL,
		exclusionExplan VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table DOCITEMS created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

//	Images		
    $sql = "CREATE TABLE images(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		imageType VARCHAR(255) NULL,
		docId INT NULL,
		userId INT NULL,
		userName VARCHAR(255) NULL,
		participantId INT NULL,
		participantName VARCHAR(255) NULL,
		imageName VARCHAR(255) NULL,
		imageFileName VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table IMAGES created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

//	ImagePages
    $sql = "CREATE TABLE imagepages(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		imagePageType VARCHAR(255) NULL,
		docId INT NULL,
		userId INT NULL,
		userName VARCHAR(255) NULL,
		participantId INT NULL,
		participantName VARCHAR(255) NULL,
		imageId INT NULL,
		imageName VARCHAR(255) NULL,
		pageNum INT NULL,
		imageFileName VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table IMAGEPAGES created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

//	Notes
    $sql = "CREATE TABLE notes(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		noteType VARCHAR(255) NULL,
		userId INT NULL,
		userName VARCHAR(255) NULL,
		participantId INT NULL,
		participantName VARCHAR(255) NULL,
		particInsPlanId INT NULL,
		particInsPlanName VARCHAR(255) NULL,
		docType VARCHAR(255) NULL,
		tableName VARCHAR(255) NULL,
		recordId INT NULL,
		noteText TEXT NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table NOTES created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

//	Logs
    $sql = "CREATE TABLE logs(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		tableName VARCHAR(255) NULL,
		recordId INT NULL,
		fieldName VARCHAR(255) NULL,
		action VARCHAR(255) NULL,
		oldValue VARCHAR(255) NULL,
		newValue VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table LOGS created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

// 	====================
//	Insurers Tables
// 	====================
//	Insurers
    $sql = "CREATE TABLE insurers(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		insurerType VARCHAR(255) NULL,
		insurerName VARCHAR(255) NULL,
		insurerAddr VARCHAR(255) NULL,
		insurerWebsite VARCHAR(255) NULL,
		insurerEmail VARCHAR(255) NULL,
		insurerPhone VARCHAR(255) NULL,
		insurerFax VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table INSURERES created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

//	InsurancePlans
    $sql = "CREATE TABLE insuranceplans(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		insurancePlanType VARCHAR(255) NULL,
		insurerId INT NULL,
		insurerName VARCHAR(255) NULL,
		insurancePlanName VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table INSURERANCEPLANS created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

// 	====================
//	Medical Code Tables
// 	====================
//	Codes
    $sql = "CREATE TABLE codes(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		codeType VARCHAR(255) NULL,
		code VARCHAR(255) NULL,
		codeDescr TEXT NULL,
		codeDescrType VARCHAR(255) NULL,
		codeNormDescr TEXT NULL,
		codeNormRule VARCHAR(255) NULL,
		codeSource VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table CODES created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

//	CodePrices
    $sql = "CREATE TABLE codeprices(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		codeType VARCHAR(255) NULL,
		codeId INT NULL,
		code VARCHAR(255) NULL,
		countyId INT NULL,
		countyName VARCHAR(255) NULL,
		codePriceAve TEXT NULL,
		codePriceStDev TEXT NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table CODEPRICES created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

// 	====================
//	Medicare Tables
// 	====================
//	CMS Payments
    $sql = "CREATE TABLE cmspayments(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		year VARCHAR(255) NULL,
		provider_npi VARCHAR(255) NULL,
		provider_lastorg_name VARCHAR(255) NULL,
		provider_first_name VARCHAR(255) NULL,
		provider_middle_name VARCHAR(255) NULL,
		provider_credentials VARCHAR(255) NULL,
		provider_gender VARCHAR(255) NULL,
		provider_entity_code VARCHAR(255) NULL,
		provider_street1 VARCHAR(255) NULL,
		provider_street2 VARCHAR(255) NULL,
		provider_city VARCHAR(255) NULL,
		provider_state VARCHAR(255) NULL,
		provider_country VARCHAR(255) NULL,
		provider_type VARCHAR(255) NULL,
		provider_medicare VARCHAR(255) NULL,
		place_of_service_type VARCHAR(255) NULL,
		hcpcs_code VARCHAR(255) NULL,
		hcpcs_descr VARCHAR(255) NULL,
		hcpcs_drug_indicator VARCHAR(255) NULL,
		service_count VARCHAR(255) NULL,
		bene_count VARCHAR(255) NULL,
		ave_medicare_allowed_amt VARCHAR(255) NULL,
		ave_submitted_amt VARCHAR(255) NULL,
		stdev_medicare_allowed_amt VARCHAR(255) NULL,
		stdev_submitted_amt VARCHAR(255) NULL,
		ave_medicare_payment VARCHAR(255) NULL,
		stdev_medicare_payment VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table CMSPAYMENTS created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

//	CMS Providers
    $sql = "CREATE TABLE cmsproviders(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		year VARCHAR(255) NULL,
		provider_npi VARCHAR(255) NULL,
		nppes_provider_last_org_name VARCHAR(255) NULL,
		nppes_provider_first_name VARCHAR(255) NULL,
		nppes_provider_mi VARCHAR(255) NULL,
		nppes_credentials VARCHAR(255) NULL,
		nppes_provider_gender VARCHAR(255) NULL,
		nppes_entity_code VARCHAR(255) NULL,
		nppes_provider_street1 VARCHAR(255) NULL,
		nppes_provider_street2 VARCHAR(255) NULL,
		nppes_provider_city VARCHAR(255) NULL,
		nppes_provider_zip VARCHAR(255) NULL,
		nppes_provider_state VARCHAR(255) NULL,
		nppes_provider_country VARCHAR(255) NULL,
		provider_type VARCHAR(255) NULL,
		medicare_participation_indicator VARCHAR(255) NULL,
		number_of_hcpcs VARCHAR(255) NULL,
		total_services VARCHAR(255) NULL,
		total_unique_benes VARCHAR(255) NULL,
		total_submitted_chrg_amt VARCHAR(255) NULL,
		total_medicare_allowed_amt VARCHAR(255) NULL,
		total_medicare_payment_amt VARCHAR(255) NULL,
		total_medicare_stnd_amt VARCHAR(255) NULL,
		drug_suppress_indicator VARCHAR(255) NULL,
		number_of_drug_hcpcs VARCHAR(255) NULL,
		total_drug_services VARCHAR(255) NULL,
		total_drug_unique_benes VARCHAR(255) NULL,
		total_drug_submitted_chrg_amt VARCHAR(255) NULL,
		total_drug_medicare_allowed_amt VARCHAR(255) NULL,
		total_drug_medicare_payment_amt VARCHAR(255) NULL,
		total_drug_medicare_stnd_amt VARCHAR(255) NULL,
		med_suppress_indicator VARCHAR(255) NULL,
		total_med_services VARCHAR(255) NULL,
		total_med_unique_benes VARCHAR(255) NULL,
		total_med_submitted_chrg_amt VARCHAR(255) NULL,
		total_med_medicare_allowed_amt VARCHAR(255) NULL,
		total_med_medicare_payment_amt VARCHAR(255) NULL,
		total_med_medicare_stnd_amt VARCHAR(255) NULL,
		beneficiary_average_age VARCHAR(255) NULL,
		beneficiary_age_less_65_count VARCHAR(255) NULL,
		beneficiary_age_65_74_count VARCHAR(255) NULL,
		beneficiary_age_75_84_count VARCHAR(255) NULL,
		beneficiary_age_greater_84_count VARCHAR(255) NULL,
		beneficiary_female_count VARCHAR(255) NULL,
		beneficiary_male_count VARCHAR(255) NULL,
		beneficiary_race_white_count VARCHAR(255) NULL,
		beneficiary_race_black_count VARCHAR(255) NULL,
		beneficiary_race_api_count VARCHAR(255) NULL,
		beneficiary_race_hispanic_count VARCHAR(255) NULL,
		beneficiary_race_natind_count VARCHAR(255) NULL,
		beneficiary_race_other_count VARCHAR(255) NULL,
		beneficiary_nondual_count VARCHAR(255) NULL,
		beneficiary_dual_count VARCHAR(255) NULL,
		beneficiary_cc_afib_percent VARCHAR(255) NULL,
		beneficiary_cc_alzrdsd_percent VARCHAR(255) NULL,
		beneficiary_cc_asthma_percent VARCHAR(255) NULL,
		beneficiary_cc_cancer_percent VARCHAR(255) NULL,
		beneficiary_cc_chf_percent VARCHAR(255) NULL,
		beneficiary_cc_ckd_percent VARCHAR(255) NULL,
		beneficiary_cc_copd_percent VARCHAR(255) NULL,
		beneficiary_cc_depr_percent VARCHAR(255) NULL,
		beneficiary_cc_diab_percent VARCHAR(255) NULL,
		beneficiary_cc_hyperl_percent VARCHAR(255) NULL,
		beneficiary_cc_hypert_percent VARCHAR(255) NULL,
		beneficiary_cc_ihd_percent VARCHAR(255) NULL,
		beneficiary_cc_ost_percent VARCHAR(255) NULL,
		beneficiary_cc_raoa_percent VARCHAR(255) NULL,
		beneficiary_cc_schiot_percent VARCHAR(255) NULL,
		beneficiary_cc_strk_percent VARCHAR(255) NULL,
		beneficiary_average_risk_score VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table CMSPROVIDERS created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

// 	====================
//	Aux Tables
// 	====================
//	Counties
    $sql = "CREATE TABLE counties(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		county VARCHAR(255) NULL,
		state VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table COUNTIES created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

// Zips
    $sql = "CREATE TABLE zips(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		zip VARCHAR(255) NULL,
		county VARCHAR(255) NULL,
		state VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
    if ($mysqli->query($sql) === true)
        echo("Table ZIPS created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

// 	====================
//	Info Tables
// 	====================
//	HomepageTexts
    $sql = "CREATE TABLE homepagetexts(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		uploadedTime INT NULL,
		updatedTime INT NULL,
		deleted INT NULL,
		textType VARCHAR(255) NULL,
		textTitle VARCHAR(255) NULL,
		textBody TEXT NULL,
		comments VARCHAR(255) NULL
	)";

    if ($mysqli->query($sql) === true)
        echo("Table HOMEPAGETEXTS created successfully\n");
    else
        echo("ERROR: unable to execute $sql. " . $mysqli->error . "\n");

// Close connection
    $mysqli->close();
}

function insert_sample_records($dbname) {
    echo("Started insert_sample_records...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        die("ERROR: Could not connect. " . $mysqli->connect_error);

// Attempt insert query execution
// 	====================
//	User Info Tables
// 	====================
//	Users
    $sql = "INSERT INTO users (uploadedTime, updatedTime, deleted, userType, userName, userEmail, userPassword, userExternalId, userPictFilename, comments) VALUES
		('', '', 0, '', 'Jane', 'jane@ymail.com', '12345678', '1', '', ''),
		('', '', 0, '', 'Mary123', 'mary123@xyz.com', '87654321', '2', '', '')
	";

    if ($mysqli->query($sql) === true)
        echo "USERS records inserted successfully\n";
    else
        die("ERROR: Could not execute $sql. " . $mysqli->error);

//	Participants
    $sql = "INSERT INTO participants (uploadedTime, updatedTime, deleted, particType, userId, userName, participantName, gender, age, relatToUser, particPictFilename, comments) VALUES
		('', '', 0, '', 1, 'Jane', 'Jane', 'F', 35, 'self', '', ''),
		('', '', 0, '', 1, 'Jane', 'John', 'M', 38, 'husband', '', ''),
		('', '', 0, '', 1, 'Jane', 'Brendan', 'M', 12, 'son', '', ''),
		('', '', 0, '', 1, 'Jane', 'Ashley', 'F', 10, 'daughter', '', ''),
		('', '', 0, '', 1, 'Jane', 'Barbara', 'F', 67, 'mother', '', ''),
		('', '', 0, '', 2, 'Mary123', 'Mary', 'F', 45, 'self', '', ''),
		('', '', 0, '', 2, 'Mary123', 'Jake', 'M', 46, 'husband', '', ''),
		('', '', 0, '', 2, 'Mary123', 'James', 'M', 37, 'brother', '', ''),
		('', '', 0, '', 2, 'Mary123', 'Jake Sr.', 'M', 72, 'father in law', '', ''),
		('', '', 0, '', 2, 'Mary123', 'Maria', 'F', 67, 'mother in law', '', '')
	";

    if ($mysqli->query($sql) === true)
        echo "USERS records inserted successfully\n";
    else
        die("ERROR: Could not execute $sql. " . $mysqli->error);


//	Insurers
    $sql = "INSERT INTO insurers (uploadedTime, updatedTime, deleted, insurerType, insurerName, insurerAddr, insurerWebsite, insurerEmail, insurerPhone, insurerFax, comments) VALUES
		('', '', 0, 'Medical', 'Cigna', '', 'www.cigna.com', '', '', '', ''),
		('', '', 0, 'Medical', 'Regency', '', 'www.regency.com', '', '', '', ''),
		('', '', 0, 'Dental', 'Delta Dental', '', 'https://www.deltadental.com', '', '', '', '')
	";

    if ($mysqli->query($sql) === true)
        echo "INSURERS records inserted successfully\n";
    else
        die("ERROR: Could not execute $sql. " . $mysqli->error);


//	InsurancePlans
    $sql = "INSERT INTO insuranceplans (uploadedTime, updatedTime, deleted, insurancePlanType, insurerId, insurerName, insurancePlanName, comments) VALUES
		('', '', 0, 'PPO', 1, 'Cigna', 'Cigna PPO 5000', ''),
		('', '', 0, 'EPO', 1, 'Cigna', 'Cigna EPO 2500', ''),
		('', '', 0, 'EPO', 2, 'Regency', 'FocalNetwork Bronze 3500', ''),
		('', '', 0, 'EPO', 2, 'Regency', 'EPO Gold 1000', ''),
		('', '', 0, 'HMO', 2, 'Regency', 'HMO 2000', ''),
		('', '', 0, 'PPO', 3, 'Delta Dental', 'PPO USA', '')
	";

    if ($mysqli->query($sql) === true)
        echo "INSURANCEPLANS records inserted successfully\n";
    else
        die("ERROR: Could not execute $sql. " . $mysqli->error);


//	ParticInsPlans
    $sql = "INSERT INTO particinsplans (uploadedTime, updatedTime, deleted, insurancePlanType, userId, userName, participantId, participantName, 
										particInsurerName, particInsPlanName, primaryInsPlan, startDate, endDate, monthlyPremium, deductInNetworkFamily, 
										deductInNetworkIndiv, deductOutNetworkFamily, deductOutNetworkIndiv, maxOopInNetworkFamily, maxOopInNetworkIndiv, 
										maxOopOutNetworkFamily, maxOopOutNetworkIndiv, deductAppliedToOop, comments) VALUES
		('', '', 0, 'PPO', 1, 'Jane', 1, 'Jane', 'Cigna', 'Cigna PPO 5000', 1, '01/01/2017', '12/31/2017', '524.37', '8000', '5000', '15000', '12000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 1, 'Jane', 2, 'John', 'Cigna', 'Cigna PPO 5000', 1, '01/01/2017', '12/31/2017', '524.37', '8000', '5000', '15000', '12000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 1, 'Jane', 3, 'Brendan', 'Cigna', 'Cigna PPO 5000', 1, '01/01/2017', '12/31/2017', '524.37', '8000', '5000', '15000', '12000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 1, 'Jane', 4, 'Ashley', 'Cigna', 'Cigna PPO 5000', 1, '01/01/2017', '12/31/2017', '524.37', '8000', '5000', '15000', '12000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 1, 'Jane', 1, 'Jane', 'PPO USA', 'PPO USA', 1, '03/01/2017', '12/31/2017', '54.12', '100', '50', '', '', '', '', '', '', 0, ''),
		('', '', 0, 'PPO', 1, 'Jane', 2, 'John', 'PPO USA', 'PPO USA', 1, '05/01/2017', '12/31/2017', '54.12', '100', '50', '', '', '', '', '', '', 0, ''),
		('', '', 0, 'PPO', 1, 'Jane', 5, 'Barbara', 'Regence', 'FocalNetwork Bronze 3500', 1, '01/01/2017', '12/31/2017', '342.00', '5000', '3500', '11000', '8000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 2, 'Mary123', 6, 'Mary', 'Cigna', 'Cigna EPO 2500', 1, '01/01/2017', '12/31/2017', '415.78', '6000', '2500', '10000', '9000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 2, 'Mary123', 7, 'Jake', 'Cigna', 'Cigna EPO 2500', 1, '01/01/2017', '12/31/2017', '415.78', '6000', '2500', '10000', '9000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 2, 'Mary123', 6, 'Mary', 'Regence', 'EPO Gold 1000', 0, '01/01/2017', '12/31/2017', '715.11', '2000', '1000', '4000', '3000', '7000', '6000', '12000', '8000', 1, ''),
		('', '', 0, 'PPO', 2, 'Mary123', 7, 'Jake', 'Regence', 'EPO Gold 1000', 0, '01/01/2017', '12/31/2017', '715.11', '2000', '1000', '4000', '3000', '7000', '6000', '120000', '8000', 1, ''),
		('', '', 0, 'PPO', 2, 'Mary123', 8, 'James', 'Regence', 'EPO Gold 1000', 1, '01/01/2017', '12/31/2017', '342.00', '5000', '3500', '11000', '8000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 2, 'Mary123', 9, 'James Sr.', 'Regence', 'HMO 2000', 1, '01/01/2017', '12/31/2017', '310.05', '5000', '2000', '6000', '4000', '10000', '8000', '15000', '10000', 1, ''),
		('', '', 0, 'PPO', 2, 'Mary123', 10, 'Maria', 'Regence', 'HMO 2000', 1, '01/01/2017', '12/31/2017', '310.05', '5000', '2000', '6000', '4000', '10000', '8000', '15000', '10000', 1, '')
	";

    if ($mysqli->query($sql) === true)
        echo "PARTICINSPLANS records inserted successfully\n";
    else
        die("ERROR: Could not execute $sql. " . $mysqli->error);


//	Docs
    $sql = "INSERT INTO docs (uploadedTime, updatedTime, deleted, docType, docStatusUpload, docStatusReview, docStatusComplete, docStatusNote, userId, userName, 
							  participantId, participantName, particInsPlanId, particInsPlanName, docTime, docAmount, indivDeductPaid, familyDeductPaid, imageFileName, comments) VALUES
		('1505583600', '', 0, 'Bill', 'uploaded', 'please review', '', 'present', 1, 'Jane', 1, 'Jane', 1, 'Cigna PPO 5000', '1505483600', '275.00', '', '', 1, ''),
		('1506593612', '', 0, 'Bill', 'uploaded', 'reviewed', '', 'present', 1, 'Jane', 2, 'John', 2, 'Cigna PPO 5000', '1506592612', '25.00', '', '', 2, ''),
		('1506693612', '', 0, 'Bill', 'uploaded', '', 'completed', '', 1, 'Jane', 2, 'John', 2, 'Cigna PPO 5000', '1506692612', '125.00', '', '', 3, ''),
		('1504077878', '', 0, 'Bill', 'uploaded', 'reviewed', 'completed', '', 1, 'Jane', 3, 'Brendan', 3, 'Cigna PPO 5000', '1504067878', '1500.00', '', '', 4, ''),
		('1503297078', '', 0, 'EOB', 'please rescan', '', '', '', 2, 'Mary123', 7, 'Jake', 9, 'Cigna EPO 2500', '1503287078', '275.00', '785.34', '1200.47', 5, ''),
		('1504297078', '', 0, 'EOB', 'uploaded', 'reviewed', '', '', 2, 'Mary123', 9, 'James Sr.', 13, 'HMO 2000', '1504287078', '275.00', '234.34', '804.50', 6, ''),
		('1505297078', '', 0, 'EOB', 'uploaded', 'reviewed', '', 'present', 1, 'Jane', 4, 'Ashley', 4, 'Cigna PPO 5000', '1505277078', '275.00', '123.55', '314.00', 7, ''),
		('1505297078', '', 0, 'EOB', 'uploaded', 'reviewed', 'completed', '', 1, 'Jane', 4, 'Ashley', 4, 'Cigna PPO 5000', '1505377078', '375.00', '123.55', '414.00', 7, ''),
		('1505297078', '', 0, 'EOB', 'uploaded', 'reviewed', 'completed', '', 1, 'Jane', 4, 'Ashley', 4, 'Cigna PPO 5000', '1505477078', '475.00', '223.55', '514.00', 7, ''),
		('1505297078', '', 0, 'EOB', 'uploaded', 'reviewed', 'completed', '', 1, 'Jane', 4, 'Ashley', 4, 'Cigna PPO 5000', '1505577078', '575.00', '323.55', '614.00', 7, '')
	";

    if ($mysqli->query($sql) === true)
        echo "DOCS records inserted successfully\n";
    else
        die("ERROR: Could not execute $sql. " . $mysqli->error);


//	ParticProviders
    $sql = "INSERT INTO particproviders (uploadedTime, updatedTime, deleted, providerType, userId, userName, participantId, participantName, providerPNI, 
										 particProviderName, providerLastName, providerFirstName, providerMiddleName, providerSpecialty, providerAddr, 
										 providerCountyId, providerCountyName, providerWebsite, providerEmail, providerPhone, providerFax, comments) VALUES
		('1505583600', '', 0, 'doctor', 1, 'Jane', 1, 'Jane', '', 'Smith, Walter S.', 'Smith', 'Walter', 'S.', 'Podiatrist',  'Chicago, IL', 1, 'Coook County', '', '', '', '', ''),
		('1506593612', '', 0, 'doctor', 1, 'Jane', 2, 'John', '', 'Jones, Allen', 'Jones', 'Allen', '', 'Cardiologist',  'Chicago, IL', 1, 'Coook County', '', '', '', '', ''),
		('1506693612', '', 0, 'lab', 1, 'Jane', 2, 'John', '', 'Regent MRI', 'Regent MRI', '', '', '',  'Chicago, IL', 1, 'Coook County', '', '', '', '', ''),
		('1504077878', '', 0, 'hospital', 1, 'Jane', 3, 'Brendan', '', 'Cook County Hospital', 'Cook County Hospital', '', '', '',  'Chicago, IL', 1, 'Coook County', '', '', '', '', '')
	";

    if ($mysqli->query($sql) === true)
        echo "PARTICPROVIDERS records inserted successfully\n";
    else
        die("ERROR: Could not execute $sql. " . $mysqli->error);


//	DocItems
    $sql = "INSERT INTO docitems (uploadedTime, updatedTime, deleted, docItemType, docId, docType, userId, userName, participantId, participantName, 
								  particInsPlanId, particInsPlanName, providerPNI, particProviderName, serviceDate, placeOfService, codeType, 
								  code, codeMod, codeQty, codeDescr, codeAltDescr, amountBilled, amountExcluded, amountAllowed, coInsAmount, coPayAmount, 
								  particPaid, excluded, exclusionCode, exclusionExplan, comments) VALUES
		('1505583600', '', 0, 'Procedure', 1, 'Bill', 1, 'Jane', 1, 'Jane', '', '', '', 'Smith, Walter S.', '03/15/17', 'doctors office', 'HCPCS', '11750', '', 2, 
								'Toenail Removal (Permanent)', '', 720.75, 220.75, 500.00, 275.00, 0, 178, '', '', '', ''),
		('1506593612', '', 0, 'Procedure', 2, 'Bill', 1, 'Jane', 2, 'John', '', '', '', 'Jones, Allen', '04/05/17', 'doctors office', 'HCPCS', '93312', '', 1, 
								'Echo transesophageal', '', 400.00, 150.00, 250.00, 25.00, 0, 0, '', '', '', ''),
		('1506693612', '', 0, 'Procedure', 3 ,'Bill', 1, 'Jane', 2, 'John', '', '', '', 'Regent MRI', '02/11/17', 'lab', 'HCPCS', '72158', '', 1, 
								'MRI Lumbar Spine w/wo Contrast', 'MRI Lumbar Spine with or without Contrast', 700.00, 150.00, 550.00, 125.00, 0, 125.00, '', '', '', ''),
		('1504077878', '', 0, 'Procedure', 4, 'Bill', 1, 'Jane', 3, 'Brendan', '', '', '', 'Cook County Hospital', '06/18/17', 'hospital', 'HCPCS', '44960', '53', 1, 
								'Appendectomy; for ruptured appendix with abscess or generalized peritonitis', '', 8540.00, 3000.00, 5540.00, 1250.00, 0, 1250.00, '', '', '', ''),
		('1504077878', '', 0, 'Procedure', 4, 'Bill', 1, 'Jane', 3, 'Brendan', '', '', '', 'Cook County Hospital', '06/18/17', 'hospital', 'HCPCS', '00840', '', 1, 
								'Anesthesia', '', 1520.00, 250.00, 1270.00, 250.00, 0, 250.00, '', '', '', ''),
		('1504077878', '', 0, 'Procedure', 4, 'Bill', 1, 'Jane', 3, 'Brendan', '', '', '', 'Cook County Hospital', '06/18/17', 'hospital', 'ICD10', 'K35.3', '', '', 
								'Appendicitis with rupture', '', '', '', '', '', '', '', '', '', '', '')
	";

    if ($mysqli->query($sql) === true)
        echo "DOCITEMS records inserted successfully\n";
    else
        die("ERROR: Could not execute $sql. " . $mysqli->error);


//	Images
    $sql = "INSERT INTO images (uploadedTime, updatedTime, deleted, imageType, docId, userId, userName, participantId, participantName, imageName, comments) VALUES
		('1505583600', '', 0, 'Bill', 1, 1, 'Jane', 1, 'Jane', 'Bill_Jane_Jane_1', ''),
		('1506593612', '', 0, 'Bill', 2, 1, 'Jane', 2, 'John', 'Bill_Jane_John_1', ''),
		('1506693612', '', 0, 'Bill', 3, 1, 'Jane', 2, 'John', 'Bill_Jane_John_2', ''),
		('1504077878', '', 0, 'Bill', 4, 1, 'Jane', 3, 'Brendan', 'Bill_Jane_Brendan_1', ''),
		('1503297078', '', 0, 'EOB', 5, 2, 'Mary123', 7, 'Jake', 'EOB_Mary123_Jake_1', ''),
		('1504297078', '', 0, 'EOB', 6, 2, 'Mary123', 9, 'James Sr.', 'EOB_Mary123_James_Sr._1', ''),
		('1505297078', '', 0, 'EOB', 7, 1, 'Jane', 4, 'Ashley', 'Bill_Jane_Ashley_1', '')
	";

    if ($mysqli->query($sql) === true)
        echo "IMAGES records inserted successfully\n";
    else
        die("ERROR: Could not able to execute $sql. " . $mysqli->error);


//	ImagePages
    $sql = "INSERT INTO imagepages (uploadedTime, updatedTime, deleted, imagePageType, docId, userId, userName, participantId, participantName, imageName, pageNum, imageFileName, comments) VALUES
		('1505583600', '', 0, 'Bill', 1, 1, 'Jane', 1, 'Jane', 'Bill_Jane_Jane_1', 1, '1_Jane_Bill_1_1', ''),
		('1505583600', '', 0, 'Bill', 1, 1, 'Jane', 1, 'Jane', 'Bill_Jane_Jane_1', 2, '1_Jane_Bill_1_2', ''),
		('1506593612', '', 0, 'Bill', 2, 1, 'Jane', 2, 'John', 'Bill_Jane_John_1', 1, '1_John_Bill_1_1', ''),
		('1506693612', '', 0, 'Bill', 3, 1, 'Jane', 2, 'John', 'Bill_Jane_John_2', 1, '1_John_Bill_2_1', ''),
		('1504077878', '', 0, 'Bill', 4, 1, 'Jane', 3, 'Brendan', 'Bill_Jane_Brendan_1', 1, '1_Brendan_Bill_1_1',''),
		('1504077878', '', 0, 'Bill', 4, 1, 'Jane', 3, 'Brendan', 'Bill_Jane_Brendan_1', 2, '1_Brendan_Bill_1_2',''),
		('1504077878', '', 0, 'Bill', 4, 1, 'Jane', 3, 'Brendan', 'Bill_Jane_Brendan_1', 3, '1_Brendan_Bill_1_3',''),
		('1503297078', '', 0, 'EOB', 5, 2, 'Mary123', 7, 'Jake', 'EOB_Mary123_Jake_1', 1, '2_Jake_EOB_1_1', ''),
		('1504297078', '', 0, 'EOB', 6, 2, 'Mary123', 9, 'James Sr.', 'EOB_Mary123_James_Sr._1', 1, '2_JamesSr_EOB_1_1', ''),
		('1505297078', '', 0, 'EOB', 7, 1, 'Jane', 4, 'Ashley', 'Bill_Jane_Ashley_1', 1, '1_Ashley_Bill_1_1', ''),
		('1505297078', '', 0, 'EOB', 7, 1, 'Jane', 4, 'Ashley', 'Bill_Jane_Ashley_1', 2, '1_Ashley_Bill_1_2', ''),
		('1505297078', '', 0, 'EOB', 7, 1, 'Jane', 4, 'Ashley', 'Bill_Jane_Ashley_1', 3, '1_Ashley_Bill_1_3', ''),
		('1505297078', '', 0, 'EOB', 7, 1, 'Jane', 4, 'Ashley', 'Bill_Jane_Ashley_1', 4, '1_Ashley_Bill_1_4', '')
	";

    if ($mysqli->query($sql) === true)
        echo "IMAGEPAGES records inserted successfully\n";
    else
        die("ERROR: Could not execute $sql. " . $mysqli->error);

//	Codes
    $sql = "INSERT INTO codes (uploadedTime, updatedTime, deleted, codeType, code, codeDescr, codeDescrType, codeNormDescr, codeNormRule, omments) VALUES
		('1505583600', '', 0, 'CPT', '11750', 'Toenail Removal (Permanent)', 'Short Descr', '', '', ''),
		('1506593612', '', 0, 'CPT', '93312', 'Echo transesophageal', 'Short Descr', '', '',  ''),
		('1506693612', '', 0, 'CPT', '72158', 'MRI Lumbar Spine w/wo Contrast', 'Short Descr', '', '',  ''),
		('1506693612', '', 0, 'CPT', '72158', 'MRI Lumbar Spine with or without Contrast', 'Medium Descr', '', '',  ''),
		('1504077878', '', 0, 'CPT', '44960', 'Appendectomy; for ruptured appendix with abscess or generalized peritonitis', 'Medium Descr', '', '',  ''),
		('1504077878', '', 0, 'CPT', '00840', 'Anesthesia', 'Short Descr', '', '',  ''),
		('1504077878', '', 0, 'ICD10', 'K35.3', 'Appendicitis with rupture', 'Short Descr', '', '',  '')
	";

    if ($mysqli->query($sql) === true)
        echo "CODES records inserted successfully\n";
    else
        die("ERROR: Could not execute $sql. " . $mysqli->error);


//	Counties
    $sql = "INSERT INTO counties (county, state, comments) VALUES
		('Cook County', 'IL', '')
	";

    if ($mysqli->query($sql) === true)
        echo "COUNTIES records inserted successfully\n";
    else
        die("ERROR: Could not execute $sql. " . $mysqli->error);


//	CodePricess
    $sql = "INSERT INTO codeprices (uploadedTime, updatedTime, deleted, codeType, codeId, code, countyId, countyName, codePriceAve, codePriceStDev, comments) VALUES
		('', '', 0, 'HCPCS', 1, '11750', 1, 'Cook County, IL', 220.13, '', ''),
		('', '', 0, 'HCPCS', 2, '93312', 1, 'Cook County, IL', 125.00, '', ''),
		('', '', 0, 'HCPCS', 3, '72158', 1, 'Cook County, IL', 135.00, '', ''),
		('', '', 0, 'HCPCS', 4, '44960', 1, 'Cook County, IL', '', '', ''),
		('', '', 0, 'HCPCS', 5, '00840', 1, 'Cook County, IL', 512.34, '', '')
	";

    if ($mysqli->query($sql) === true)
        echo "CODEPRICES records inserted successfully\n";
    else
        die("ERROR: Could not execute $sql. " . $mysqli->error);


//	Notes
    $sql = "INSERT INTO notes (uploadedTime, updatedTime, deleted, noteType, userId, userName, participantId, participantName, 
							   particInsPlanId, particInsPlanName, doctype, tableName, recordId, noteText, comments) VALUES
		('1505584600', '', 0, '', 1, 'Jane', 1, 'Jane', '', '', 'Bill', 'docs', 1, 'Jane still complaining for pain. Should she ask for a second opinion?', ''),
		('1506595612', '', 0, '', 1, 'Jane', 2, 'John', '', '', 'Bill', 'docs', 2, 'Johns throat finally is not swallen. Need to write a thank you note to the doctor', ''),
		('1505298078', '', 0, '', 1, 'Jane', 4, 'Ashley', 4, 'Cigna PPO 5000', 'EOB', 'docs', 7, 'Why the deductible (Ashleys and for the whole family) shown as paid is so low? I paid much more this year for Ashley already. Neeed to call Cigna', '')
	";

    if ($mysqli->query($sql) === true)
        echo "NOTES records inserted successfully\n";
    else
        die("ERROR: Could not execute $sql. " . $mysqli->error);

//	HomepageTexts
    $sql = "INSERT INTO homepagetexts (uploadedTime, updatedTime, deleted, textType, textTitle, textBody, comments) VALUES
		('1505584600', '', '', '', 'Main Intro', 'Glendor app helps you ...', ''),
		('1505584600', '', '', '', 'Privacy Note', 'BlaBlaBla ...', '')
	";

    if ($mysqli->query($sql) === true)
        echo "HOMEPAGETEXTS records inserted successfully\n";
    else
        die("ERROR: Could not execute $sql. " . $mysqli->error);

// Close connection
    $mysqli->close();
}

function get_doc_list($dbname, $userId, $participantId, $dateFrom, $dateTo) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');

    if (empty($userId))
        returnError('userId is empty');

    $sql = "SELECT id, uploadedTime, updatedTime, deleted, docType, docStatusUpload, docStatusReview, docStatusComplete, docStatusNote, 
				   userName, participantId, participantName, particInsPlanName FROM docs WHERE deleted = 0 AND userId = " . $userId;
    if (!empty($participantId))
        $sql .= " AND participantId = " . $participantId;
    if (empty($dateFrom))
        $begsec = 0;
    $endsec = 2147483647;
    if (!empty($dateFrom))
        $begsec = strtotime($dateFrom);
    if (!empty($dateTo))
        $endsec = strtotime($dateTo);
    $sql .= " AND uploadedTime >= " . $begsec . " AND uploadedTime <= " . $endsec;
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
    $docListRes = array();
    while ($row = $res->fetch_assoc()) {
        $docListRes[] = $row;
    }
    $res->close();

// Close connection
    $mysqli->close();
    returnResponse($docListRes);
}

function get_doc_details($dbname, $userId, $participantId, $docId) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($participantId))
        returnError('participantId is empty');
    if (empty($docId))
        returnError('docid is empty');

    $sql = "SELECT id, docType FROM docs WHERE deleted = 0 AND id = " . $docId;
    $res = $mysqli->query($sql);
    $type = "";
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $type = $row['docType'];
            break;
        }
        $res->close();
    }
    $sql = "SELECT id, uploadedTime, updatedTime, deleted, docType, docStatusUpload, docStatusReview, docStatusComplete, docStatusNote, 
				   userName, participantId, participantName, docTime, docAmount ";
//	if (!strcasecmp ($type, "EOB"))
    $sql .= ", particInsPlanName, indivDeductPaid, familyDeductPaid ";
    $sql .= ", imageId FROM docs WHERE deleted = 0 AND id = " . $docId;
    $sql .= " AND userId = " . $userId;
    $sql .= " AND participantId = " . $participantId;
    $res = $mysqli->query($sql);
    $docsDetailRes = array();
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $docsDetailRes[] = $row;
        }
        $res->close();
    }

// Close connection
    $mysqli->close();
    returnResponse($docsDetailRes);
}

function get_doc_items($dbname, $userId, $participantId, $docId) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');

    if (empty($userId))
        returnError('userId is empty');
    if (empty($participantId))
        returnError('participantId is empty');
    if (empty($docId))
        returnError('docId is empty');

    $sql = "SELECT id, docType FROM docs WHERE deleted = 0 AND id = " . $docId;
    $res = $mysqli->query($sql);
    $type = "";
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $type = $row['docType'];
            break;
        }
        $res->close();
    }
    $sql = "SELECT id, uploadedTime, updatedTime, deleted, docItemType, docId, docType, userName, participantId, participantName";
//	if (!strcasecmp ($type, "EOB"))
    $sql .= ", particInsPlanName";
    $sql .= ", providerPNI, particProviderName, serviceDate, placeOfService, codeType, code, codeMod, codeQty, codeDescr, codeAltDescr, amountBilled ";
//	if (!strcasecmp ($type, "EOB"))
    $sql .= ", amountExcluded, amountAllowed, coInsAmount, coPayAmount, particPaid, excluded, exclusionCode, exclusionExplan";
    $sql .= " FROM docitems WHERE deleted = 0 AND docId = " . $docId .= " AND userId = '" . $userId .= "' AND participantId = " . $participantId;
    $res = $mysqli->query($sql);
//var_dump($sql, $mysqli);	
    $docItemRes = array();
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $docItemRes[] = $row;
        }
        $res->close();
    }

// Close connection
    $mysqli->close();
    returnResponse($docItemRes);
}

function get_home_page_texts($dbname) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');

    $sql = "SELECT * FROM homepagetexts WHERE deleted = 0";
    $res = $mysqli->query($sql);
    $homePageTextRes = array();
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $homePageTextRes[] = $row;
        }
        $res->close();
    }
// Close connection
    $mysqli->close();
    returnResponse($homePageTextRes);
}

function get_glendor_snapshot($dbname, $userId, $participantId, $eobOnly) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');

    $snapshotRes = array();
    $sql = "SELECT count(id) as countid FROM docs WHERE deleted = 0 AND userId = " . $userId;
    if (!empty($participantId))
        $sql .= " AND participantId = " . $participantId;
    if (!empty($eobOnly))
        $sql .= " AND docType = 'EOB'";
    $tot_uploaded = 0;
    $res = $mysqli->query($sql);
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $tot_uploaded = $row['countid'];
            break;
        }
    }
    $res->close();
    $sql .= " AND docStatusComplete <> ''";
    $tot_completed = 0;
    $res = $mysqli->query($sql);
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $tot_completed = $row['countid'];
            break;
        }
    }
    $res->close();
    $snapshotRes['docs_uploded'] = $tot_uploaded;
    $snapshotRes['docs_completed'] = $tot_completed;
    $snapshotRes['docs_completion_perc'] = 0;
    if ($tot_uploaded > 0)
        $snapshotRes['docs_completion_perc'] = $tot_completed * 100 / $tot_uploaded;

    $sql = "SELECT max(docs.docTime), docs.id, docs.participantId, docs.participantName, docs.particInsPlanId, docs.particInsPlanName, docs.indivDeductPaid, 
			particinsplans.deductInNetworkIndiv
			FROM `docs` INNER JOIN particinsplans on docs.particInsPlanId = particinsplans.id
			WHERE docs.docType = 'EOB' AND docs.indivDeductPaid is not null AND docs.userId = " . $userId;
    if (!empty($participantId))
        $sql .= " AND docs.participantId = " . $participantId;
    $sql .= " group by docs.participantId, docs.particInsPlanId";

    $res = $mysqli->query($sql);
    $snapshotRes['deduct'] = array();
    $count = 0;
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $snapshotRes['deduct'][$count]['participantId'] = $row['participantId'];
            $snapshotRes['deduct'][$count]['participantName'] = $row['participantName'];
            $snapshotRes['deduct'][$count]['particInsPlanId'] = $row['particInsPlanId'];
            $snapshotRes['deduct'][$count]['particInsPlanName'] = $row['particInsPlanName'];
            $snapshotRes['deduct'][$count]['deductible'] = $row['deductInNetworkIndiv'];
            $snapshotRes['deduct'][$count]['deductPaid'] = $row['indivDeductPaid'];
            if ($snapshotRes['deduct'][$count]['deductible'] > 0)
                $snapshotRes['deduct'][$count]['deduct_paid_percent'] = $snapshotRes['deduct'][$count]['deductPaid'] * 100 / $snapshotRes['deduct'][$count]['deductible'];
            $count ++;
        }
    }
    $res->close();

// Close connection
    $mysqli->close();
    returnResponse($snapshotRes);
}

function get_notes($dbname, $userId, $docId, $participantId, $particInsPlanId) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');

    $sql = "SELECT notes.uploadedTime, notes.updatedTime, notes.noteText, notes.participantId, notes.participantName, notes.particInsPlanId, notes.particInsPlanName, 
				   notes.tableName, notes.recordId 
			FROM notes INNER JOIN docs ON notes.userId = docs.userId";
    if (!empty($participantId))
        $sql .= " AND notes.participantId = docs.participantId";
    if (!empty($particInsPlanId))
        $sql .= " AND notes.particInsPlanId = docs.particInsPlanId";
    $sql .= " WHERE notes.deleted = 0 AND docs.deleted = 0 AND docs.docStatusComplete = ''";
    if (!empty($docId))
        $sql .= " AND notes.tableName = 'docs' AND notes.recordId = " . $docId;

    $res = $mysqli->query($sql);
    $noteRes = array();
    if (!($res === false)) {
        $count = 0;
        while ($row = $res->fetch_assoc()) {
            $noteRes[$count]['id'] = $row['id'];
            $timestamp = $row['uploadedTime'];
            if ($timestamp < $row['updatedTime'])
                $timestamp = $row['updatedTime'];
            $noteRes[$count]['timestamp'] = $timestamp;
            $noteRes[$count]['noteText'] = $row['noteText'];
            $noteRes[$count]['participantId'] = $row['participantId'];
            $noteRes[$count]['participantName'] = $row['participantName'];
            $noteRes[$count]['particInsPlanId'] = $row['particInsPlanId'];
            $noteRes[$count]['particInsPlanName'] = $row['particInsPlanName'];
            $noteRes[$count]['docId'] = $row['recordId'];
        }
        $res->close();
    }

// Close connection
    $mysqli->close();
    returnResponse($noteRes);
}

function get_partic_ins_plans($dbname, $userId, $participantId) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');

    $sql = "SELECT id, participantId, participantName, particInsurerName, particInsPlanName FROM particinsplans WHERE deleted = 0";
    $sql .= " AND userId = " . $userId;
    if (!empty($participantId))
        $sql .= " AND participantId = " . $participantId;
    $sql .= " ORDER BY participantId DESC";
    $res = $mysqli->query($sql);
    $particInsPlanRes = array();

    while ($row = $res->fetch_assoc()) {
        $row['userId'] = NULL;   // obscure userId
        $particInsPlanRes[] = $row;
    }
    $res->close();

// Close connection
    $mysqli->close();
    returnResponse($particInsPlanRes);
}

function get_participants($dbname, $userId, $participantId) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');

    $sql = "SELECT id, participantName, gender, age, relatToUser, particPictFilename FROM participants WHERE deleted = 0";
    $sql .= " AND userId = " . $userId;
    if (!empty($participantId))
        $sql .= " AND id = " . $participantId;
    $sql .= " ORDER BY id ASC";
    $res = $mysqli->query($sql);
    $participantRes = array();
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $participantRes[] = $row;
        }
        $res->close();
    }
// Close connection
    $mysqli->close();
    returnResponse($participantRes);
}

function get_particproviders($dbname, $userId, $participantId) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');

    $sql = "SELECT id, uploadedTime, updatedTime, providerType, providerPNI, particProviderName, providerLastName, providerFirstName, providerMiddleName, 
				   providerSpecialty, providerAddr, providerCountyName, providerWebsite, providerEmail, providerPhone, providerFax 
				   FROM particproviders WHERE deleted = 0";
    $sql .= " AND userId = " . $userId;
    if (!empty($participantId))
        $sql .= " AND id = " . $participantId;
    $sql .= " ORDER BY id ASC";
    $res = $mysqli->query($sql);
    $particProviderRes = array();
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $particProviderRes[] = $row;
        }
        $res->close();
    }
// Close connection
    $mysqli->close();
    returnResponse($particProviderRes);
}

function log_new_record($dbname, $tableName, $record) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
    foreach ($record as $rkey => $r) {
        $sql = "INSERT INTO logs (uploadedTime, tableName, recordId, fieldName, action, oldValue, newValue) VALUES
								 ('" . $record['uploadedTime'] . "', '" . $tableName . "', '" . $record['id'] . "', '" . $rkey . "', 'new', '', '" . $r . "')";
        $res = $mysqli->query($sql);
        if ($res === false)
            returnError('Sql error');
    }
// Close connection
    $mysqli->close();
}

function log_mod_record($dbname, $tableName, $recordNew, $recordOld) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');

    foreach ($recordNew as $rkey => $r) {
        $sql = "INSERT INTO logs (updatedTime, tableName, recordId, fieldName, action, oldValue, newValue) VALUES
								 ('" . $recordNew['updatedTime'] . "', '" . $tableName . "', '" . $recordNew['id'] . "', '" . $rkey . "', 'mod', '" . $recordOld[$rkey] . "', '" . $r . "')";
        $res = $mysqli->query($sql);
        if ($res === false)
            returnError('Sql error');
    }
// Close connection
    $mysqli->close();
}

function add_participant($dbname, $userId, $participantJSON) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
//var_dump($dbname, $userId, $participantJSON);	

    if (empty($userId))
        returnError('userId is empty');
    if (empty($participantJSON))
        returnError('Empty participantJSON');

    $uploadedTime = time();
    $sql = "SELECT id, userName FROM users WHERE deleted = 0 AND id = " . $userId;
    $res = $mysqli->query($sql);
    $userName = "";
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $userName = $row['userName'];
            break;
        }
        $res->close();
    }

    $sql = "INSERT INTO participants (uploadedTime, updatedTime, deleted, particType, userId, userName, participantName, gender, age, relatToUser, particPictFilename) VALUES
		('" . $uploadedTime . "', '', '', '', '" . $userId . "', '" . $userName . "', '" . $participantJSON['participantName'] . "', '" . $participantJSON['gender'] . "', '" . $participantJSON['age'] . "', '" . $participantJSON['relatToUser'] . "', '" . $participantJSON['particPictFilename'] . "')";

    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
    $participantId = $mysqli->insert_id;
    $sql = "SELECT uploadedTime, updatedTime, deleted, particType, userName, participantName, gender, age, relatToUser, particPictFilename 
			FROM participants WHERE deleted = 0 AND id = " . $participantId;
    $res = $mysqli->query($sql);
    while ($record = $res->fetch_assoc()) {
        break;
    }
    $res->close();
// Close connection
    $mysqli->close();
    log_new_record($dbname, $tableName, $record);
    $response["participantId"] = $participantId;
    returnResponse($response);
}

function mod_participant($dbname, $userId, $participantId, $participantJSON) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
//var_dump($userId, $participantId, $participantJSON);	
    if (empty($userId))
        returnError('userId is empty');
    if (empty($participantId))
        returnError('participantId is empty');
    if (empty($participantJSON))
        returnError('participantJSON is empty');

    $sql = "SELECT * FROM participants WHERE deleted = 0 AND id = " . $participantId;
    $res = $mysqli->query($sql);
    $participantOld = array();
    if (!($res === false)) {
        while ($participantOld = $res->fetch_assoc()) {
            break;
        }
        $res->close();
    }
    $participantJSON['updatedTime'] = time();
//    $participantJSON['id'] = $participantId;
    $sql = "UPDATE participants SET";
//var_dump($participantJSON);	
    foreach ($participantJSON as $fieldname => $fieldvalue) {
        if (!strcasecmp($fieldname, "userId"))
            continue;
        $sql .= " " . $fieldname . "='" . $fieldvalue . "',";
    }
    $sql = preg_replace('/,\s*$/', '', $sql);
    $sql = sprintf("%s WHERE userId='%s' AND id='%s'", $sql, $userId, $participantId);
    $res = $mysqli->query($sql);
//var_dump($sql);	
    if ($res === false)
        returnError('Sql error');
// Close connection
    $mysqli->close();
    log_mod_record($dbname, 'participants', $participantJSON, $participantOld);
    $response["participantId"] = $participantId;
    returnResponse($response);
}

function add_partic_ins_plan($dbname, $userId, $participantId, $particInsPlanJSON) {
    $plan = $particInsPlanJSON;
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
//var_dump($userId, $participantId, $particInsPlanJSON);	
    if (empty($userId))
        returnError('userId is empty');
    if (empty($participantId))
        returnError('participantId is empty');
    if (empty($particInsPlanJSON))
        returnError('particInsPlanJSON is empty');

    $uploadedTime = time();
    $sql = "SELECT userName, participantName FROM participants WHERE deleted = 0 AND userid = " . $userId . " AND id = " . $participantId;
    $res = $mysqli->query($sql);
    $userName = "";
    $participantName = "";
    while ($row = $res->fetch_assoc()) {
        $userName = $row['userName'];
        $participantName = $row['participantName'];
        break;
    }
    $res->close();

    $sql = "INSERT INTO particinsplans (uploadedTime, updatedTime, deleted, userId, userName, participantId, participantName, 
										particInsurerName, particInsPlanName) VALUES
									   ('" . $uploadedTime . "', '', '', '" . $userId . "', '" . $userName . "', '" . $participantId . "', 
									    '" . $participantName . "', '" . $plan['particInsurerName'] . "', '" . $plan['particInsPlanName'] . "')";
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
    $particinsplanId = $mysqli->insert_id;
    $sql = "SELECT * FROM particinsplans WHERE deleted = 0 AND id = " . $particinsplanId;
    $res = $mysqli->query($sql);
    while ($record = $res->fetch_assoc()) {
        break;
    }
    $res->close();
// Close connection
    $mysqli->close();
    log_new_record($dbname, $tableName, $record);
    $response["particInsPlanId"] = $particinsplanId;
    returnResponse($response);
}

function mod_partic_ins_plan($dbname, $userId, $particInsPlanId, $particInsPlanJSON) {
    $plan = $particInsPlanJSON;
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($particInsPlanId))
        returnError('particInsPlanId is empty');
    if (empty($particInsPlanJSON))
        returnError('particInsPlanJSON is empty');

    $sql = "SELECT * FROM particinsplans WHERE deleted = 0 AND id = " . $particInsPlanId;
    $res = $mysqli->query($sql);
    $particInsPlanOld = array();
    if (!($res === false)) {
        while ($particInsPlanOld = $res->fetch_assoc()) {
            break;
        }
        $res->close();
    }
    $plan['updatedTime'] = time();
    $plan['id'] = $particInsPlanId;

    $sql = "UPDATE particinsplans SET ";
    foreach ($plan as $fieldname => $fieldvalue) {
        if (!strcasecmp($fieldname, "userId"))
            continue;
        $sql .= " " . $fieldname . "='" . $fieldvalue . "',";
    }
    $sql = preg_replace('/,\s*$/', '', $sql);
    $sql = sprintf("%s WHERE userId = '%s' AND id = '%s'", $sql, $userId, $particInsPlanId);
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
// Close connection
    $mysqli->close();
    log_mod_record($dbname, 'particinsplans', $plan, $particInsPlanOld);
    $response["particInsPlanId"] = $particInsPlanId;
    returnResponse($response);
}

function add_partic_provider($dbname, $userId, $participantId, $particProviderJSON) {
    $provider = $particProviderJSON;
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($participantId))
        returnError('participantId is empty');
    if (empty($particProviderJSON))
        returnError('particProviderJSON is empty ');

    $uploadedTime = time();
    $sql = "SELECT userName, participantName FROM participants WHERE deleted = 0 AND userId = " . $userId . " AND id = " . $participantId;
    $res = $mysqli->query($sql);
    $userName = "";
    $participantName = "";
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $userName = $row['userName'];
            $participantName = $row['participantName'];
            break;
        }
        $res->close();
    }
    $sql = "INSERT INTO particproviders (uploadedTime, updatedTime, deleted, providerType, userId, userName, participantId, participantName, 
										 particProviderName, providerLastName, providerFirstName, providerMiddleName, providerSpecialty) VALUES
									   ('" . $uploadedTime . "', '', '', '" . $provider['providerType'] . "', '" . $userId . "', '" . $userName . "', '" . $participantId . "',
									    '" . $participantName . "', '" . $provider['particProviderName'] . "', '" . $provider['providerLastName'] . "', 
										'" . $provider['providerFirstName'] . "', '" . $provider['providerMiddleName'] . "', '" . $provider['providerSpecialty'] . "')";
    $res = $mysqli->query($sql);
    if ($res === false)
        die("ERROR: Could not execute $sql. " . $mysqli->error);
    $particProviderId = $mysqli->insert_id;
    $sql = "SELECT * FROM particproviders WHERE deleted = 0 AND id = " . $particProviderId;
    $res = $mysqli->query($sql);
    while ($record = $res->fetch_assoc()) {
        break;
    }
    $res->close();
// Close connection
    $mysqli->close();
    log_new_record($dbname, 'particproviders', $record);
    $response["particProviderId"] = $particProviderId;
    returnResponse($response);
}

function mod_partic_provider($dbname, $userId, $particProviderId, $particProviderJSON) {
    $provider = $particProviderJSON;
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($particProviderId))
        returnError('particProviderId is empty');
    if (empty($particProviderJSON))
        returnError('particProviderJSON is empty');

    $sql = "SELECT * FROM particproviders WHERE deleted = 0 AND id = " . $particProviderId;
    $res = $mysqli->query($sql);
    $particProviderOld = array();
    if (!($res === false)) {
        while ($particProviderOld = $res->fetch_assoc()) {
            break;
        }
        $res->close();
    }
    $provider['updatedTime'] = time();
    $provider['id'] = $particProviderId;
    $sql = "UPDATE particproviders SET";
    foreach ($provider as $fieldname => $fieldvalue) {
        if (!strcasecmp($fieldname, "userId"))
            continue;
        $sql .= " " . $fieldname . "='" . $fieldvalue . "',";
    }
    $sql = preg_replace('/,\s*$/', '', $sql);
    $sql = sprintf("%s WHERE userId='%s' AND id='%s'", $sql, $userId, $particProviderId);
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
// Close connection
    $mysqli->close();
    log_mod_record($dbname, 'particproviders', $provider, $particProviderOld);
    $response["particProviderId"] = $particProviderId;
    returnResponse($response);
}

function add_note($dbname, $userId, $participantId, $docId, $noteJSON) {
    $note = $noteJSON;
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($participantId))
        returnError('participantId is empty');
    if (empty($docId))
        returnError('docId is empty');
    if (empty($noteJSON))
        returnError('noteJSON is empty');

    $uploadedTime = time();
    $sql = "SELECT userName, participantName FROM participants WHERE deleted = 0 AND userid = " . $userId . " AND id = " . $participantId;
    $res = $mysqli->query($sql);
    $userName = "";
    $participantName = "";
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $userName = $row['userName'];
            $participantName = $row['participantName'];
            break;
        }
        $res->close();
    }

    $sql = "INSERT INTO notes (uploadedTime, updatedTime, deleted, noteType, userId, userName, participantId, participantName, particInsPlanName, 
							   tableName, recordId, noteText) VALUES
							   ('" . $uploadedTime . "', '', '', '" . $note['noteType'] . "', '" . $userId . "', '" . $userName . "', '" . $participantId . "', '" . $participantName . "',
							    '" . $note['particInsPlanName'] . "', '" . "docs" . "', '" . $docId . "', '" . $note['noteText'] . "')";
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
    $noteId = $mysqli->insert_id;
    $sql = "SELECT * FROM notes WHERE deleted = 0 AND id = " . $noteId;
    $res = $mysqli->query($sql);
    while ($record = $res->fetch_assoc()) {
        break;
    }
    $res->close();
// Close connection
    $mysqli->close();
    log_new_record($dbname, 'notes', $record);
    $response["noteId"] = $noteId;
    returnResponse($response);
}

function mod_note($dbname, $userId, $noteId, $noteJSON) {
    $note = $noteJSON;
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($noteId))
        returnError('noteId is empty');
    if (empty($noteJSON))
        returnError('noteJSON is empty');

    $sql = "SELECT * FROM notes WHERE deleted = 0 AND id = " . $noteId;
    $res = $mysqli->query($sql);
    $noteOld = array();
    if (!($res === false)) {
        while ($noteOld = $res->fetch_assoc()) {
            break;
        }
        $res->close();
    }
    $note['updatedTime'] = time();
    $note['id'] = $noteId;
    $sql = "UPDATE notes SET";
    foreach ($note as $fieldname => $fieldvalue) {
        if (!strcasecmp($fieldname, "userId"))
            continue;
        $sql .= " " . $fieldname . "='" . $fieldvalue . "',";
    }
    $sql = preg_replace('/,\s*$/', '', $sql);
    $sql = sprintf("%s WHERE userId='%s' AND id='%s'", $sql, $userId, $noteId);
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
// Close connection
    $mysqli->close();
    log_mod_record($dbname, 'notes', $note, $noteOld);
    $response["noteId"] = $noteId;
    returnResponse($response);
}

function mod_doc($dbname, $userId, $docId, $docJSON) {
    $doc = $docJSON;
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($docId))
        returnError('docId is empty');
    if (empty($docJSON))
        returnError('docJSON is empty');

    $sql = "SELECT * FROM docs WHERE deleted = 0 AND id = " . $docId;
    $res = $mysqli->query($sql);
    $docOld = array();
    if (!($res === false)) {
        while ($docOld = $res->fetch_assoc()) {
            break;
        }
        $res->close();
    }
    $doc['updatedTime'] = time();
    $doc['id'] = $docId;
    $sql = "UPDATE docs SET";
    foreach ($doc as $fieldname => $fieldvalue) {
        if (!strcasecmp($fieldname, "userId"))
            continue;
        $sql .= " " . $fieldname . "='" . $fieldvalue . "',";
    }
    $sql = preg_replace('/,\s*$/', '', $sql);
    $sql = sprintf("%s WHERE userId='%s' AND id='%s'", $sql, $userId, $docId);
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
// Close connection
    $mysqli->close();
    log_mod_record($dbname, 'docs', $doc, $docOld);
    $response["docId"] = $docId;
    returnResponse($response);
}

function mod_docitem($dbname, $userId, $docItemId, $docitemJSON) {
    $docitem = $docitemJSON;
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($docItemId))
        returnError('docItemId is empty');
    if (empty($docitemJSON))
        returnError('docitemJSON is empty');

    $sql = "SELECT * FROM docitems WHERE deleted = 0 AND id = " . $docItemId;
    $res = $mysqli->query($sql);
    $docitemOld = array();
    if (!($res === false)) {
        while ($docitemOld = $res->fetch_assoc()) {
            break;
        }
        $res->close();
    }
    $docitem['updatedTime'] = time();
    $docitem['id'] = $docItemId;
    $sql = "UPDATE docitems SET";
    foreach ($docitem as $fieldname => $fieldvalue) {
        if (!strcasecmp($fieldname, "userId"))
            continue;
        $sql .= " " . $fieldname . "='" . $fieldvalue . "',";
    }
    $sql = preg_replace('/,\s*$/', '', $sql);
    $sql = sprintf("%s WHERE userId='%s' AND id='%s'", $sql, $userId, $docItemId);
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
// Close connection
    $mysqli->close();
    log_mod_record($dbname, 'docitems', $docitem, $docitemOld);
    $response["docItemId"] = $docItemId;
    returnResponse($response);
}

function make_userexternalid($userId) {
    $userExternalId = openssl_random_pseudo_bytes(100, $crypto_strong);
    $userExternalId = bin2hex($userExternalId);
    return ($userExternalId);
}

function add_user($dbname, $userJSON) {
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userJSON))
        returnError('userJSON is empty');
    if (empty($userJSON['userName']))
        returnError('userName is empty');
    if (empty($userJSON['userEmail']))
        returnError('userEmail is empty');
    if (strlen($userJSON['userPassword']) < 8)
        returnError('userPassword should have at least 8 characters');

    $sql = "SELECT id FROM users WHERE deleted = 0 AND userEmail = '" . $userJSON['userEmail'] . "'";
    $res = $mysqli->query($sql);
    $flag = false;
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $flag = true;
            break;
        }
        $res->close();
    }
    if ($flag)
        returnError('User with this email already exists');
//die;		
    $uploadedTime = time();
    $sql = "INSERT INTO users (uploadedTime, updatedTime, deleted, userType, userName, userEmail, userPassword, userExternalId, comments) VALUES
		('" . $uploadedTime . "', '', '', '', '" . $userJSON['userName'] . "', '" . $userJSON['userEmail'] . "', '" . $userJSON['userPassword'] . "', '', '')";
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
    $userId = $mysqli->insert_id;
    $sql = "SELECT * FROM users WHERE deleted = 0 AND id = '" . $userId . "'";
    $res = $mysqli->query($sql);
    while ($record = $res->fetch_assoc()) {
        break;
    }
    $res->close();
    $userExternalId = make_userexternalid($userId);
    $sql = "SELECT userExternalId FROM users WHERE deleted = 0";
    $res = $mysqli->query($sql);
    $flag = false;
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $flag = true;
            break;
        }
        $res->close();
    }
    if (!$flag)
        returnError("Can't add the user");
    $sql = "UPDATE users SET userExternalId = '" . $userExternalId . "' WHERE id = " . $userId;
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
    $mysqli->close();
    $record['userExternalId'] = $userExternalId;
    log_new_record($dbname, $tableName, $record);
    $response["userId"] = $userExternalId;
    returnResponse($response);
}

function mod_user($dbname, $userId, $userJSON) {
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($userJSON))
        returnError('userJSON is empty');

    $sql = "SELECT * FROM users WHERE deleted = 0 AND id = " . $userId;
    $res = $mysqli->query($sql);
    $userOld = array();
    if (!($res === false)) {
        while ($userOld = $res->fetch_assoc()) {
            break;
        }
        $res->close();
    }
    if (!empty($userJSON['userEmail'])) {
        $sql = "SELECT id FROM users WHERE deleted = 0 AND userEmail = '" . $userJSON['userEmail'] . "'";
        $res = $mysqli->query($sql);
        if (!($res === false)) {
            while ($row = $res->fetch_assoc()) {
                if ($row['id'] != $userId)
                    returnError('a different user with this email exists');
            }
            $res->close();
        }
    }

    $userJSON['updatedTime'] = time();
    $sql = "UPDATE users SET";
    foreach ($userJSON as $fieldname => $fieldvalue) {
        if (!strcasecmp($fieldname, "userId"))
            continue;
        $sql .= " " . $fieldname . "='" . $fieldvalue . "',";
    }
    $sql = preg_replace('/,\s*$/', '', $sql);
    $sql = sprintf("%s WHERE id='%s'", $sql, $userId);
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
    $mysqli->close();
    log_mod_record($dbname, 'users', $userJSON, $userOld);
    $response["userId"] = $userId;
    returnResponse($response);
}

function get_user_id($dbname, $userJSON) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');

    if (empty($userJSON))
        returnError('userJSON is empty');
    if (empty($userJSON['userEmail']))
        returnError('userEmail is empty');
    if (empty($userJSON['userPassword']))
        returnError('userPassword is empty');

    $sql = "SELECT userName, userEmail, userExternalId, userPictFilename FROM users 
			WHERE deleted = 0 AND userEmail = '" . $userJSON['userEmail'] . "' AND userPassword = '" . $userJSON['userPassword'] . "'";
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
    $userRes = array();
    while ($row = $res->fetch_assoc()) {
        $userRes = $row;
        $userRes['userId'] = $row['userExternalId'];
        break;
    }
    $res->close();

// Close connection
    $mysqli->close();
    if (empty($userRes['userId']))
        returnError('Incorrect user email/password');
    returnResponse($userRes);
}

function get_user_details($dbname, $userId) {
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');

    $sql = "SELECT userName, userEmail, userPictFilename FROM users WHERE deleted = 0 AND id = " . $userId;
    $res = $mysqli->query($sql);
    $userRes = array();
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $userRes[] = $row;
        }
        $res->close();
    }
// Close connection
    $mysqli->close();
    returnResponse($userRes);
}

function user_forgot_password($dbname, $userJSON) {
//	Need to send email to user with temporary password that user will change to the new one
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userJSON))
        returnError('userJSON is empty');
    if (empty($userJSON['userEmail']))
        returnError('userEmail is empty');

    $sql = "SELECT id FROM users WHERE deleted = 0 AND userEmail = '" . $userJSON['userEmail'] . "'";
    $res = $mysqli->query($sql);
    $flag = false;
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $flag = true;
            break;
        }
        $res->close();
    }
    if (!$flag)
        returnError('User with this email does not exist');

    $response['message'] = "Email with temporary password was sent";
    returnResponse($response);
}

function add_doc_image($dbname, $userId, $participantId, $imageJSON) {
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($participantId))
        returnError('participantId is empty');
    if (empty($imageJSON))
        returnError('imageJSON is empty');
    if (empty($imageJSON['image']))
        returnError('imageJSON has empty image');

    $uploadedTime = time();
    $sql = "SELECT userName, participantName FROM participants WHERE deleted = 0 AND userid = " . $userId . " AND id = " . $participantId;
    $res = $mysqli->query($sql);
    $userName = "";
    $participantName = "";
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $userName = $row['userName'];
            $participantName = $row['participantName'];
            break;
        }
        $res->close();
    }

    $imageFileName = "c:/__Glendor/UserImages/doc_" . $participantId . "_" . $uploadedTime . ".jpg";
    $image = base64_decode($imageJSON['image']);
    file_put_contents($imageFileName, $image);
    $sql = "INSERT INTO docs (uploadedTime, updatedTime, deleted, docType, docStatusUpload, docStatusReview, docStatusComplete, docStatusNote, 
				userId, userName, participantId, participantName, particInsPlanName, docTime, docAmount, indivDeductPaid, familyDeductPaid, imageFileName, comments) VALUES
				('" . $uploadedTime . "', '', '', '', 'uploaded', '', '', '', '" . $userId . "', '" . $userName . "', '" . $participantId . "', 
				'" . $participantName . "', '', '', '', '', '', '" . $imageFileName . "', '')";
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
    $docId = $mysqli->insert_id;
    $sql = "SELECT * FROM docs WHERE deleted = 0 AND id = " . $docId;
    $res = $mysqli->query($sql);
    while ($record = $res->fetch_assoc()) {
        break;
    }
    $res->close();
    $mysqli->close();
    log_new_record($dbname, 'docs', $record);
    $response["imageFileName"] = $imageFileName;
    $response["docId"] = $docId;
    returnResponse($response);
}

function mod_doc_image($dbname, $userId, $docId, $imageJSON) {
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($docId))
        returnError('docId is empty');
    if (empty($imageJSON))
        returnError('imageJSON is empty');
    if (empty($imageJSON['image']))
        returnError('imageJSON has empty image');

    $updatedTime = time();
    $sql = "SELECT imageFileName FROM docs WHERE deleted = 0 AND userid = '" . $userId . "' AND id = " . $docId;
    $res = $mysqli->query($sql);
    $imageFileName = "";
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $imageFileName = $row['imageFileName'];
            break;
        }
        $res->close();
    }
    $sql = "UPDATE docs SET updatedTime = " . $updatedTime . " WHERE userId = '" . $userId . "' AND id = " . $docId;
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
    $image = base64_decode($imageJSON['image']);
    if (!empty($imageFileName))
        file_put_contents($imageFileName, $image);
    $mysqli->close();
    $new['updatedTime'] = $updatedTime;
    $old['updatedTime'] = "";
    log_mod_record($dbname, 'docs', $new['updatedTime'], $old['updatedTime']);
    $response["imageFileName"] = $imageFileName;
    $response["docId"] = $docId;
    returnResponse($response);
}

function get_doc_image($dbname, $userId, $docId) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($docId))
        returnError('docId is empty');

    $sql = "SELECT imageFileName FROM docs WHERE deleted = 0 AND id = " . $docId . " AND userId = " . $userId;
    $res = $mysqli->query($sql);
    $imageFileName = "";
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $imageFileName = $row['imageFileName'];
            break;
        }
        $res->close();
    }

    $image = "";
    if (!empty($imageFileName))
        $image = file_get_contents($imageFileName, $image);
    $imageRes['imageFileName'] = $imageFileName;
    $imageRes['image'] = base64_encode($image);

//file_put_contents ("c:/__Glendor/UserImages/img1.json", json_encode($imageRes));	

    returnResponse($imageRes);
}

function add_partic_picture($dbname, $userId, $participantId, $imageJSON) {
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($participantId))
        returnError('participantId is empty');
    if (empty($imageJSON))
        returnError('imageJSON is empty');
    if (empty($imageJSON['image']))
        returnError('imageJSON has empty image');

    $updatedTime = time();
    $imageFileName = "c:/__Glendor/UserImages/partic_" . $participantId . "_" . $updatedTime . ".jpg";
    $image = base64_decode($imageJSON['image']);
    file_put_contents($imageFileName, $image);
    $sql = "SELECT * FROM participants WHERE deleted = 0 AND id = " . $participantId;
    $res = $mysqli->query($sql);
    while ($recordOld = $res->fetch_assoc()) {
        break;
    }
    $res->close();
    $sql = "UPDATE participants SET updatedTime = " . $updatedTime . ", particPictFilename = '" . $imageFileName . "' WHERE userId = '" . $userId . "' AND id = " . $participantId;
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
    $sql = "SELECT * FROM participants WHERE deleted = 0 AND id = " . $participantId;
    $res = $mysqli->query($sql);
    while ($recordNew = $res->fetch_assoc()) {
        break;
    }
    $res->close();
    $mysqli->close();
    log_mod_record($dbname, 'participants', $recordNew, $recordOld);
    $response["participantId"] = $participantId;
    $response["particPictFilename"] = $imageFileName;
    returnResponse($response);
}

function mod_partic_picture($dbname, $userId, $participantId, $imageJSON) {
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($participantId))
        returnError('participantId is empty');
    if (empty($imageJSON))
        returnError('imageJSON is empty');
    if (empty($imageJSON['image']))
        returnError('imageJSON has empty image');

    $updatedTime = time();
    $sql = "SELECT * FROM participants WHERE deleted = 0 AND id = " . $participantId;
    $res = $mysqli->query($sql);
    while ($recordOld = $res->fetch_assoc()) {
        break;
    }
    $res->close();
    $sql = "SELECT particPictFilename FROM participants WHERE deleted = 0 AND userid = '" . $userId . "' AND id = " . $participantId;
    $res = $mysqli->query($sql);
    $imageFileName = "";
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $imageFileName = $row['particPictFilename'];
            break;
        }
        $res->close();
    }
    $sql = "UPDATE participants SET updatedTime = " . $updatedTime . " WHERE userId = '" . $userId . "' AND id = " . $participantId;
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
    $sql = "SELECT * FROM participants WHERE deleted = 0 AND id = " . $participantId;
    $res = $mysqli->query($sql);
    while ($recordNew = $res->fetch_assoc()) {
        break;
    }
    $res->close();
    $image = base64_decode($imageJSON['image']);
    if (!empty($imageFileName))
        file_put_contents($imageFileName, $image);
    $mysqli->close();
    log_mod_record($dbname, 'participants', $recordNew, $recordOld);
    $response["participantId"] = $participantId;
    $response["particPictFilename"] = $imageFileName;
    returnResponse($response);
}

function get_partic_picture($dbname, $userId, $participantId) {
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
// Check connection
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($participantId))
        returnError('participantId is empty');

    $sql = "SELECT particPictFilename FROM participants WHERE deleted = 0 AND id = " . $participantId . " AND userId = " . $userId;
    $res = $mysqli->query($sql);
//var_dump($mysqli);	
    $imageFileName = "";
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $imageFileName = $row['particPictFilename'];
            break;
        }
        $res->close();
    }

    $image = "";
    if (!empty($imageFileName))
        $image = file_get_contents($imageFileName, $image);
    $imageRes['image'] = base64_encode($image);
    $imageRes["particPictFilename"] = $imageFileName;

//file_put_contents ("c:/__Glendor/UserImages/img1.json", json_encode($imageRes));	

    returnResponse($imageRes);
}

function add_user_picture($dbname, $userId, $imageJSON) {
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($imageJSON))
        returnError('imageJSON is empty');
    if (empty($imageJSON['image']))
        returnError('imageJSON has empty image');

    $updatedTime = time();
    $imageFileName = "c:/__Glendor/UserImages/user_" . $userId . "_" . $updatedTime . ".jpg";
    $image = base64_decode($imageJSON['image']);
    file_put_contents($imageFileName, $image);
    $sql = "SELECT userPictFilename FROM users WHERE deleted = 0 AND id = '" . $userId . "'";
    $res = $mysqli->query($sql);
    while ($recordOld = $res->fetch_assoc()) {
        break;
    }
    $res->close();
    $sql = "UPDATE users SET updatedTime = " . $updatedTime . ", userPictFilename = '" . $imageFileName . "' WHERE id = '" . $userId . "'";
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
    $sql = "SELECT * FROM users WHERE deleted = 0 AND id = " . $userId;
    $res = $mysqli->query($sql);
    while ($recordNew = $res->fetch_assoc()) {
        break;
    }
    $res->close();
    $mysqli->close();
    log_mod_record($dbname, 'users', $recordNew, $recordOld);
    $response["userId"] = $userId;
    $response["userPictFilename"] = $imageFileName;
    returnResponse($response);
}

function mod_user_picture($dbname, $userId, $imageJSON) {
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');
    if (empty($imageJSON))
        returnError('imageJSON is empty');
    if (empty($imageJSON['image']))
        returnError('imageJSON has empty image');

    $updatedTime = time();
    $sql = "SELECT * FROM users WHERE deleted = 0 AND id = " . $userId;
    $res = $mysqli->query($sql);
    while ($recordOld = $res->fetch_assoc()) {
        break;
    }
    $res->close();
    $sql = "SELECT userPictFilename FROM users WHERE deleted = 0 AND id = '" . $userId . "'";
    $res = $mysqli->query($sql);
    $imageFileName = "";
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $imageFileName = $row['userPictFilename'];
            break;
        }
        $res->close();
    }
    $sql = "UPDATE users SET updatedTime = " . $updatedTime . " WHERE id = '" . $userId . "'";
    $res = $mysqli->query($sql);
    if ($res === false)
        returnError('Sql error');
    $sql = "SELECT * FROM users WHERE deleted = 0 AND id = '" . $userId . "'";
    $res = $mysqli->query($sql);
    while ($recordNew = $res->fetch_assoc()) {
        break;
    }
    $res->close();
    $image = base64_decode($imageJSON['image']);
    if (!empty($imageFileName))
        file_put_contents($imageFileName, $image);
    $mysqli->close();
    log_mod_record($dbname, 'users', $recordNew, $recordOld);
    $response["userId"] = $userId;
    $response["userPictFilename"] = $imageFileName;
    returnResponse($response);
}

function get_user_picture($dbname, $userId) {
    $mysqli = new mysqli($GLOBALS['hostName'], $GLOBALS['userName'], $GLOBALS['password'], $dbname);
    if ($mysqli === false)
        returnError('Sql Connection error');
    if (empty($userId))
        returnError('userId is empty');

    $sql = "SELECT userPictFilename FROM users WHERE deleted = 0 AND id = '" . $userId . "'";
    $res = $mysqli->query($sql);
    $imageFileName = "";
    if (!($res === false)) {
        while ($row = $res->fetch_assoc()) {
            $imageFileName = $row['userPictFilename'];
            break;
        }
        $res->close();
    }

    $image = "";
    if (!empty($imageFileName))
        $image = file_get_contents($imageFileName, $image);
    $imageRes['image'] = base64_encode($image);
    $imageRes["userPictFilename"] = $imageFileName;

//file_put_contents ("c:/__Glendor/UserImages/img1.json", json_encode($imageRes));	

    returnResponse($imageRes);
}

function main() {
// main function
    global $cfg;
    $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
    $action = $request[0];
    $cfg = json_decode(file_get_contents('php://input'), true);
    $cfg['dbname'] = "glendor";
//var_dump($cfg);	
//	Auth
    if (isset($cfg['userId'])) {
        if (!verify_userexternalid($cfg['dbname'], $cfg['userId']))
            returnError('userId is incorrect');
        $cfg['userId'] = get_userinternalid($cfg['dbname'], $cfg['userId']);
    }
    if ($action == "build_db_schema")
        build_db_schema($cfg['dbname']);
    if ($action == "insert_sample_records")
        insert_sample_records($cfg['dbname']);
    if ($action == "get_doc_list")
        get_doc_list($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['dateFrom'], $cfg['dateTo']);
    if ($action == "get_doc_details")
        get_doc_details($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['docId']);
    if ($action == "get_doc_items")
        get_doc_items($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['docId']);
    if ($action == "get_home_page_texts")
        get_home_page_texts($cfg['dbname']);
    if ($action == "get_glendor_snapshot")
        get_glendor_snapshot($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['eobOnly']);
    if ($action == "get_notes")
        get_notes($cfg['dbname'], $cfg['userId'], $cfg['docId'], $cfg['participantId'], $cfg['particInsPlanId']);
    if ($action == "get_partic_ins_plans")
        get_partic_ins_plans($cfg['dbname'], $cfg['userId'], $cfg['participantId']);
    if ($action == "get_participants")
        get_participants($cfg['dbname'], $cfg['userId'], $cfg['participantId']);
    if ($action == "get_particproviders")
        get_particproviders($cfg['dbname'], $cfg['userId'], $cfg['participantId']);
    if ($action == "add_participant")
        add_participant($cfg['dbname'], $cfg['userId'], $cfg['participantJSON']);
    if ($action == "mod_participant")
        mod_participant($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['participantJSON']);
    if ($action == "add_partic_ins_plan")
        add_partic_ins_plan($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['particInsPlanJSON']);
    if ($action == "mod_partic_ins_plan")
        mod_partic_ins_plan($cfg['dbname'], $cfg['userId'], $cfg['particInsPlanId'], $cfg['particInsPlanJSON']);
    if ($action == "add_partic_provider")
        add_partic_provider($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['particProviderJSON']);
    if ($action == "mod_partic_provider")
        mod_partic_provider($cfg['dbname'], $cfg['userId'], $cfg['particProviderId'], $cfg['particProviderJSON']);
    if ($action == "add_note")
        add_note($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['docId'], $cfg['noteJSON']);
    if ($action == "mod_note")
        mod_note($cfg['dbname'], $cfg['userId'], $cfg['noteId'], $cfg['noteJSON']);
    if ($action == "mod_doc")
        mod_doc($cfg['dbname'], $cfg['userId'], $cfg['docId'], $cfg['docJSON']);
    if ($action == "mod_docitem")
        mod_docitem($cfg['dbname'], $cfg['userId'], $cfg['docitemId'], $cfg['docitemJSON']);

    if ($action == "add_user")
        add_user($cfg['dbname'], $cfg['userJSON']);
    if ($action == "mod_user")
        mod_user($cfg['dbname'], $cfg['userId'], $cfg['userJSON']);
    if ($action == "get_user_id")
        get_user_id($cfg['dbname'], $cfg['userJSON']);
    if ($action == "get_user_details")
        get_user_details($cfg['dbname'], $cfg['userId']);
    if ($action == "user_forgot_password")
        user_forgot_password($cfg['dbname'], $cfg['userJSON']);
    if ($action == "add_doc_image")
        add_doc_image($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['imageJSON']);
    if ($action == "mod_doc_image")
        mod_doc_image($cfg['dbname'], $cfg['userId'], $cfg['docId'], $cfg['imageJSON']);
    if ($action == "get_doc_image")
        get_doc_image($cfg['dbname'], $cfg['userId'], $cfg['docId']);
    if ($action == "add_partic_picture")
        add_partic_picture($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['imageJSON']);
    if ($action == "mod_partic_picture")
        mod_partic_picture($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['imageJSON']);
    if ($action == "get_partic_picture")
        get_partic_picture($cfg['dbname'], $cfg['userId'], $cfg['participantId']);
    if ($action == "add_user_picture")
        add_user_picture($cfg['dbname'], $cfg['userId'], $cfg['imageJSON']);
    if ($action == "mod_user_picture")
        mod_user_picture($cfg['dbname'], $cfg['userId'], $cfg['imageJSON']);
    if ($action == "get_user_picture")
        get_user_picture($cfg['dbname'], $cfg['userId']);
}

main();
?>