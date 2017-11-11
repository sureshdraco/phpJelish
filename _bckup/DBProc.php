<?php
error_reporting(E_ERROR);

function build_db_schema ($dbname){
	echo("Started build_db_schema...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password)
	$mysqli = new mysqli("localhost", "root", "hercules15");
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);
// Attempt to delete database query execution
	$sql = "DROP DATABASE ".$dbname;
	if($mysqli->query($sql) === true)
		echo("Database deleted successfully\n");
	else
		echo ("ERROR: unable to execute $sql. " . $mysqli->error."\n");
// Attempt to create database query execution
	$sql = "CREATE DATABASE ".$dbname;
	if($mysqli->query($sql) === true)
		echo("Database created successfully\n");
	else
		echo ("ERROR: unable to execute $sql. " . $mysqli->error."\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
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
		comments VARCHAR(255) NULL
	)";
	if($mysqli->query($sql) === true)
		echo("Table USERS created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");
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
	if($mysqli->query($sql) === true)
		echo("Table PARTICIPANTS created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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
		insurerId INT NULL,
		insurerName VARCHAR(255) NULL,
		insurancePlanId INT NULL,
		insurancePlanName VARCHAR(255) NULL,
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
	if($mysqli->query($sql) === true)
		echo("Table PARTICINSPLANS created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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
	
	if($mysqli->query($sql) === true)
		echo("Table PROVIDERS created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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
		issuedDate VARCHAR(255) NULL,
		userId INT NULL,
		userName VARCHAR(255) NULL,
		participantId INT NULL,
		participantName VARCHAR(255) NULL,
		insurerId INT NULL,
		insurerName VARCHAR(255) NULL,
		insurancePlanId INT NULL,
		insurancePlanName VARCHAR(255) NULL,
		indivDeductPaid VARCHAR(255) NULL,
		familyDeductPaid VARCHAR(255) NULL,
		imageId INT NULL,
		comments VARCHAR(255) NULL
	)";
	if($mysqli->query($sql) === true)
		echo("Table DOCS created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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
		insurerId INT NULL,
		insurerName VARCHAR(255) NULL,
		insurancePlanId INT NULL,
		insurancePlanName VARCHAR(255) NULL,
		providerPNI VARCHAR(255) NULL,
		providerName VARCHAR(255) NULL,
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
	if($mysqli->query($sql) === true)
		echo("Table DOCITEMS created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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
		comments VARCHAR(255) NULL
	)";
	if($mysqli->query($sql) === true)
		echo("Table IMAGES created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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
	if($mysqli->query($sql) === true)
		echo("Table IMAGEPAGES created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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
		insurerId INT NULL,
		insurerName VARCHAR(255) NULL,
		insurancePlanId INT NULL,
		insurancePlanName VARCHAR(255) NULL,
		docType VARCHAR(255) NULL,
		tableName VARCHAR(255) NULL,
		recordId INT NULL,
		noteText TEXT NULL,
		comments VARCHAR(255) NULL
	)";
	if($mysqli->query($sql) === true)
		echo("Table NOTES created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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
	if($mysqli->query($sql) === true)
		echo("Table LOGS created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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
	if($mysqli->query($sql) === true)
		echo("Table INSURERES created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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
	if($mysqli->query($sql) === true)
		echo("Table INSURERANCEPLANS created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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
		codeAltDescr TEXT NULL,
		comments VARCHAR(255) NULL
	)";
	if($mysqli->query($sql) === true)
		echo("Table CODES created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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
	if($mysqli->query($sql) === true)
		echo("Table CODEPRICES created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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
	if($mysqli->query($sql) === true)
		echo("Table CMSPAYMENTS created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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
	if($mysqli->query($sql) === true)
		echo("Table CMSPROVIDERS created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");
		
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
	if($mysqli->query($sql) === true)
		echo("Table COUNTIES created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

// Zips
	$sql = "CREATE TABLE zips(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		zip VARCHAR(255) NULL,
		county VARCHAR(255) NULL,
		state VARCHAR(255) NULL,
		comments VARCHAR(255) NULL
	)";
	if($mysqli->query($sql) === true)
		echo("Table ZIPS created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

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

	if($mysqli->query($sql) === true)
		echo("Table HOMEPAGETEXTS created successfully\n");
	else
		echo("ERROR: unable to execute $sql. " . $mysqli->error."\n");

// Close connection
	$mysqli->close();
}

function insert_sample_records ($dbname){
	echo("Started insert_sample_records...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);

// Attempt insert query execution

// 	====================
//	User Info Tables
// 	====================

//	Users
	$sql = "INSERT INTO users (uploadedTime, updatedTime, deleted, userType, userName, userEmail, comments) VALUES
		('', '', 0, '', 'Jane', 'jane@ymail.com', ''),
		('', '', 0, '', 'Mary123', 'mary123@xyz.com', '')
	";
	
	if($mysqli->query($sql) === true)
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
	
	if($mysqli->query($sql) === true)
	    echo "USERS records inserted successfully\n";
	else
		die("ERROR: Could not execute $sql. " . $mysqli->error);


//	Insurers
	$sql = "INSERT INTO insurers (uploadedTime, updatedTime, deleted, insurerType, insurerName, insurerAddr, insurerWebsite, insurerEmail, insurerPhone, insurerFax, comments) VALUES
		('', '', 0, 'Medical', 'Cigna', '', 'www.cigna.com', '', '', '', ''),
		('', '', 0, 'Medical', 'Regency', '', 'www.regency.com', '', '', '', ''),
		('', '', 0, 'Dental', 'Delta Dental', '', 'https://www.deltadental.com', '', '', '', '')
	";
	
	if($mysqli->query($sql) === true)
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
	
	if($mysqli->query($sql) === true)
	    echo "INSURANCEPLANS records inserted successfully\n";
	else
		die("ERROR: Could not execute $sql. " . $mysqli->error);


//	ParticInsPlans
	$sql = "INSERT INTO particinsplans (uploadedTime, updatedTime, deleted, insurancePlanType, userId, userName, participantId, participantName, insurerId, insurerName, 
										insurancePlanId, insurancePlanName, primaryInsPlan, startDate, endDate, monthlyPremium, deductInNetworkFamily, deductInNetworkIndiv,
										deductOutNetworkFamily, deductOutNetworkIndiv, maxOopInNetworkFamily, maxOopInNetworkIndiv, maxOopOutNetworkFamily, maxOopOutNetworkIndiv,
										deductAppliedToOop, comments) VALUES
		('', '', 0, 'PPO', 1, 'Jane', 1, 'Jane', 1, 'Cigna', 1, 'Cigna PPO 5000', 1, '01/01/2017', '12/31/2017', '524.37', '8000', '5000', '15000', '12000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 1, 'Jane', 2, 'John', 1, 'Cigna', 1, 'Cigna PPO 5000', 1, '01/01/2017', '12/31/2017', '524.37', '8000', '5000', '15000', '12000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 1, 'Jane', 3, 'Brendan', 1, 'Cigna', 1, 'Cigna PPO 5000', 1, '01/01/2017', '12/31/2017', '524.37', '8000', '5000', '15000', '12000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 1, 'Jane', 4, 'Ashley', 1, 'Cigna', 1, 'Cigna PPO 5000', 1, '01/01/2017', '12/31/2017', '524.37', '8000', '5000', '15000', '12000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 1, 'Jane', 1, 'Jane', 3, 'Delta Dental', 6, 'PPO USA', 1, '03/01/2017', '12/31/2017', '54.12', '100', '50', '', '', '', '', '', '', 0, ''),
		('', '', 0, 'PPO', 1, 'Jane', 2, 'John', 3, 'Delta Dental', 6, 'PPO USA', 1, '05/01/2017', '12/31/2017', '54.12', '100', '50', '', '', '', '', '', '', 0, ''),
		('', '', 0, 'PPO', 1, 'Jane', 5, 'Barbara', 2, 'Regency', 3, 'FocalNetwork Bronze 3500', 1, '01/01/2017', '12/31/2017', '342.00', '5000', '3500', '11000', '8000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 2, 'Mary123', 6, 'Mary', 1, 'Cigna', 2, 'Cigna EPO 2500', 1, '01/01/2017', '12/31/2017', '415.78', '6000', '2500', '10000', '9000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 2, 'Mary123', 7, 'Jake', 1, 'Cigna', 2, 'Cigna EPO 2500', 1, '01/01/2017', '12/31/2017', '415.78', '6000', '2500', '10000', '9000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 2, 'Mary123', 6, 'Mary', 2, 'Regency',4, 'EPO Gold 1000', 0, '01/01/2017', '12/31/2017', '715.11', '2000', '1000', '4000', '3000', '7000', '6000', '12000', '8000', 1, ''),
		('', '', 0, 'PPO', 2, 'Mary123', 7, 'Jake', 2, 'Regency', 4, 'EPO Gold 1000', 0, '01/01/2017', '12/31/2017', '715.11', '2000', '1000', '4000', '3000', '7000', '6000', '120000', '8000', 1, ''),
		('', '', 0, 'PPO', 2, 'Mary123', 8, 'James', 2, 'Regency', 3, 'EPO Gold 1000', 1, '01/01/2017', '12/31/2017', '342.00', '5000', '3500', '11000', '8000', '15000', '12000', '30000', '20000', 1, ''),
		('', '', 0, 'PPO', 2, 'Mary123', 9, 'James Sr.', 2, 'Regency', 5, 'HMO 2000', 1, '01/01/2017', '12/31/2017', '310.05', '5000', '2000', '6000', '4000', '10000', '8000', '15000', '10000', 1, ''),
		('', '', 0, 'PPO', 2, 'Mary123', 10, 'Maria', 2, 'Regency', 5, 'HMO 2000', 1, '01/01/2017', '12/31/2017', '310.05', '5000', '2000', '6000', '4000', '10000', '8000', '15000', '10000', 1, '')
	";

	if($mysqli->query($sql) === true)
	    echo "PARTICINSPLANS records inserted successfully\n";
	else
		die("ERROR: Could not execute $sql. " . $mysqli->error);


//	Docs
	$sql = "INSERT INTO docs (uploadedTime, updatedTime, deleted, docType, docStatusUpload, docStatusReview, docStatusComplete, docStatusNote,
							  issuedDate, userId, userName, participantId, participantName, insurerId, insurerName, 
							  insurancePlanId, insurancePlanName, indivDeductPaid, familyDeductPaid, imageId, comments) VALUES
		('1505583600', '', 0, 'Bill', 'uploaded', 'please review', '', 'present', '06/23/17', 1, 'Jane', 1, 'Jane', '', '', '', '', '', '', 1, ''),
		('1506593612', '', 0, 'Bill', 'uploaded', 'reviewed', '', 'present', '07/12/17', 1, 'Jane', 2, 'John', '', '', '', '', '', '', 2, ''),
		('1506693612', '', 0, 'Bill', 'uploaded', '', 'completed', '', '05/28/17', 1, 'Jane', 2, 'John', '', '', '', '', '', '', 3, ''),
		('1504077878', '', 0, 'Bill', 'uploaded', 'reviewed', 'completed', '', '09/01/17', 1, 'Jane', 3, 'Brendan', '', '', '', '', '', '', 4, ''),
		('1503297078', '', 0, 'EOB', 'please rescan', '', '', '', '01/11/17', 2, 'Mary123', 7, 'Jake', 2, 'Regency', 4, 'EPO Gold 1000', '785.34', '1200.47', 5, ''),
		('1504297078', '', 0, 'EOB', 'uploaded', 'reviewed', '', '', '05/02/17', 2, 'Mary123', 9, 'James Sr.', 2, 'Regency', 4, 'HMO 2000', '234.34', '804.50', 6, ''),
		('1505297078', '', 0, 'EOB', 'uploaded', 'reviewed', '', 'present', '10/01/17', 1, 'Jane', 4, 'Ashley', 2, 'Cigna', 4, 'Cigna PPO 5000', '123.55', '314.00', 7, '')
	";
	
	if($mysqli->query($sql) === true)
	    echo "DOCS records inserted successfully\n";
	else
		die("ERROR: Could not execute $sql. " . $mysqli->error);


//	ParticProviders
	$sql = "INSERT INTO particproviders (uploadedTime, updatedTime, deleted, providerType, userId, userName, participantId, participantName, providerPNI,  
										 providerLastName, providerFirstName, providerMiddleName, providerSpecialty, providerAddr, providerCountyId, providerCountyName,
										 providerWebsite, providerEmail, providerPhone, providerFax, comments) VALUES
		('1505583600', '', 0, 'doctor', 1, 'Jane', 1, 'Jane', '', 'Smith', 'Walter', 'S.', 'Podiatrist',  'Chicago, IL', 1, 'Coook County', '', '', '', '', ''),
		('1506593612', '', 0, 'doctor', 1, 'Jane', 2, 'John', '', 'Jones', 'Allen', '', 'Cardiologist',  'Chicago, IL', 1, 'Coook County', '', '', '', '', ''),
		('1506693612', '', 0, 'lab', 1, 'Jane', 2, 'John', '', 'Regent MRI', '', '', '',  'Chicago, IL', 1, 'Coook County', '', '', '', '', ''),
		('1504077878', '', 0, 'hospital', 1, 'Jane', 3, 'Brendan', '', 'Cook County Hospital', '', '', '',  'Chicago, IL', 1, 'Coook County', '', '', '', '', '')
	";

	if($mysqli->query($sql) === true)
	    echo "PARTICPROVIDERS records inserted successfully\n";
	else
		die("ERROR: Could not execute $sql. " . $mysqli->error);


//	DocItems
	$sql = "INSERT INTO docitems (uploadedTime, updatedTime, deleted, docItemType, docId, docType, userId, userName, participantId, participantName, insurerId, 
								  insurerName, insurancePlanId, insurancePlanName, providerPNI, providerName, serviceDate, placeOfService, codeType, code, codeMod, 
								  codeQty, codeDescr, codeAltDescr, amountBilled, amountExcluded, amountAllowed, coInsAmount, coPayAmount, particPaid,
								  excluded, exclusionCode, exclusionExplan, comments) VALUES
		('1505583600', '', 0, 'Procedure', 1, 'Bill', 1, 'Jane', 1, 'Jane', '', '', '', '', '', 'Smith, Walter S.', '03/15/17', 'doctors office', 'HCPCS', '11750', '', 2, 
								'Toenail Removal (Permanent)', '', 720.75, 220.75, 500.00, 275.00, 0, 178, '', '', '', ''),
		('1506593612', '', 0, 'Procedure', 2, 'Bill', 1, 'Jane', 2, 'John', '', '', '', '','', 'Jones, Allen', '04/05/17', 'doctors office', 'HCPCS', '93312', '', 1, 
								'Echo transesophageal', '', 400.00, 150.00, 250.00, 25.00, 0, 0, '', '', '', ''),
		('1506693612', '', 0, 'Procedure', 3 ,'Bill', 1, 'Jane', 2, 'John', '', '', '', '', '', 'Regent MRI', '02/11/17', 'lab', 'HCPCS', '72158', '', 1, 
								'MRI Lumbar Spine w/wo Contrast', 'MRI Lumbar Spine with or without Contrast', 700.00, 150.00, 550.00, 125.00, 0, 125.00, '', '', '', ''),
		('1504077878', '', 0, 'Procedure', 4, 'Bill', 1, 'Jane', 3, 'Brendan', '', '', '', '', '', 'Cook County Hospital', '06/18/17', 'hospital', 'HCPCS', '44960', '53', 1, 
								'Appendectomy; for ruptured appendix with abscess or generalized peritonitis', '', 8540.00, 3000.00, 5540.00, 1250.00, 0, 1250.00, '', '', '', ''),
		('1504077878', '', 0, 'Procedure', 4, 'Bill', 1, 'Jane', 3, 'Brendan', '', '', '', '', '', 'Cook County Hospital', '06/18/17', 'hospital', 'HCPCS', '00840', '', 1, 
								'Anesthesia', '', 1520.00, 250.00, 1270.00, 250.00, 0, 250.00, '', '', '', ''),
		('1504077878', '', 0, 'Procedure', 4, 'Bill', 1, 'Jane', 3, 'Brendan', '', '', '', '', '', 'Cook County Hospital', '06/18/17', 'hospital', 'ICD10', 'K35.3', '', '', 
								'Appendicitis with rupture', '', '', '', '', '', '', '', '', '', '', '')
	";

	if($mysqli->query($sql) === true)
	    echo "DOCITEMS records inserted successfully\n";
	else
		die("ERROR: Could not execute $sql. " . $mysqli->error);


//	Images
	$sql = "INSERT INTO images (uploadedTime, updatedTime, deleted, imageType, docId, userId, userName, participantId, participantName, imageGroupName, comments) VALUES
		('1505583600', '', 0, 'Bill', 1, 1, 'Jane', 1, 'Jane', 'Bill_Jane_Jane_1', ''),
		('1506593612', '', 0, 'Bill', 2, 1, 'Jane', 2, 'John', 'Bill_Jane_John_1', ''),
		('1506693612', '', 0, 'Bill', 3, 1, 'Jane', 2, 'John', 'Bill_Jane_John_2', ''),
		('1504077878', '', 0, 'Bill', 4, 1, 'Jane', 3, 'Brendan', 'Bill_Jane_Brendan_1', ''),
		('1503297078', '', 0, 'EOB', 5, 2, 'Mary123', 7, 'Jake', 'EOB_Mary123_Jake_1', ''),
		('1504297078', '', 0, 'EOB', 6, 2, 'Mary123', 9, 'James Sr.', 'EOB_Mary123_James_Sr._1', ''),
		('1505297078', '', 0, 'EOB', 7, 1, 'Jane', 4, 'Ashley', 'Bill_Jane_Ashley_1', '')
	";

	if($mysqli->query($sql) === true)
	    echo "IMAGES records inserted successfully\n";
	else
		die("ERROR: Could not able to execute $sql. " . $mysqli->error);

	
//	ImagePages
	$sql = "INSERT INTO imagepages (uploadedTime, updatedTime, deleted, imagePageType, docId, userId, userName, participantId, participantName, imageGroupName, pageNum, imageFileName, comments) VALUES
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

	if($mysqli->query($sql) === true)
	    echo "IMAGEPAGES records inserted successfully\n";
	else
		die("ERROR: Could not execute $sql. " . $mysqli->error);


//	Codes
	$sql = "INSERT INTO codes (uploadedTime, updatedTime, deleted, codeType, code, codeDescr, codeAltDescr, comments) VALUES
		('1505583600', '', 0, 'HCPCS', '11750', 'Toenail Removal (Permanent)', '', ''),
		('1506593612', '', 0, 'HCPCS', '93312', 'Echo transesophageal', '', ''),
		('1506693612', '', 0, 'HCPCS', '72158', 'MRI Lumbar Spine w/wo Contrast', 'MRI Lumbar Spine with or without Contrast', ''),
		('1504077878', '', 0, 'HCPCS', '44960', 'Appendectomy; for ruptured appendix with abscess or generalized peritonitis', '', ''),
		('1504077878', '', 0, 'HCPCS', '00840', 'Anesthesia', '', ''),
		('1504077878', '', 0, 'ICD10', 'K35.3', 'Appendicitis with rupture', '', '')
	";

	if($mysqli->query($sql) === true)
	    echo "CODES records inserted successfully\n";
	else
		die("ERROR: Could not execute $sql. " . $mysqli->error);


//	Counties
	$sql = "INSERT INTO counties (county, state, comments) VALUES
		('Cook County', 'IL', '')
	";

	if($mysqli->query($sql) === true)
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

	if($mysqli->query($sql) === true)
	    echo "CODEPRICES records inserted successfully\n";
	else
		die("ERROR: Could not execute $sql. " . $mysqli->error);


//	Notes
	$sql = "INSERT INTO notes (uploadedTime, updatedTime, deleted, noteType, userId, userName, participantId, participantName, insurerId, insurerName, insurancePlanId, insurancePlanName,
							   doctype, tableName, recordId, noteText, comments) VALUES
		('1505584600', '', 0, '', 1, 'Jane', 1, 'Jane', '', '', '', '', 'Bill', 'docitems', 1, 'Jane still complaining for pain. Should she ask for a second opinion?', ''),
		('1506595612', '', 0, '', 1, 'Jane', 2, 'John', '', '', '', '', 'Bill', 'docitems', 2, 'Johns throat finally is not swallen. Need to write a thank you note to the doctor', ''),
		('1505298078', '', 0, '', 1, 'Jane', 4, 'Ashley', 1, 'Cigna', 1, 'Cigna PPO 5000', 'EOB', 'docs', 7, 'Why the deductible (Ashleys and for the whole family) shown as paid is so low? I paid much more this year for Ashley already. Neeed to call Cigna', '')
	";

	if($mysqli->query($sql) === true)
	    echo "NOTES records inserted successfully\n";
	else
		die("ERROR: Could not execute $sql. " . $mysqli->error);

//	HomepageTexts
	$sql = "INSERT INTO homepagetexts (uploadedTime, updatedTime, deleted, textType, textTitle, textBody, comments) VALUES
		('1505584600', '', '', '', 'Main Intro', 'Glendor app helps you ...', ''),
		('1505584600', '', '', '', 'Privacy Note', 'BlaBlaBla ...', '')
	";

	if($mysqli->query($sql) === true)
	    echo "HOMEPAGETEXTS records inserted successfully\n";
	else
		die("ERROR: Could not execute $sql. " . $mysqli->error);

// Close connection
	$mysqli->close();
}

function get_doc_list ($dbname, $userId, $participantId, $year){
	echo("Started get_doc_list ...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);

	$sql = "SELECT uploadedTime, updatedTime, deleted, docType, docStatusUpload, docStatusReview, docStatusComplete, docStatusNote, 
				   userId, userName, participantId, participantName, insurerId, insurerName, insurancePlanId, insurancePlanName 
			FROM docs 
			WHERE deleted = 0";
	if (!empty($userId))	
		$sql .= " AND userId = ".$userId;
	if (!empty($participantId))	
		$sql .= " AND participantId = ".$participantId;
	if (!empty($year)) {	
		$begyear = strtotime ("1 January ".$year);
		$endyear = strtotime ("31 December ".$year);
		$sql .= " AND uploadedTime >= ".$begyear." AND uploadedTime <= ".$endyear;
	}
	$res = $mysqli->query($sql);
	if($res === false)
		die("ERROR: Could not execute $sql. " . $mysqli->error);
	$docListRes = array();
	while ($row = $res->fetch_assoc()) {	
		$docListRes[] = $row;	
	}	
	$res->close();

// Close connection
	$mysqli->close();
	$docListResJSON = json_encode ($docListRes);
var_dump($docListRes, $docListResJSON);
	return $docListResJSON;	
}

function get_doc_details ($dbname, $userId, $participantId, $docid){
	echo("Started get_doc_details ...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);

	$sql = "SELECT id, docType FROM docs WHERE deleted = 0 AND id = ".$docid;
	$res= $mysqli->query($sql);
	$type = "";
	if (!($res === false)) {
		while ($row = $res->fetch_assoc()) {	
			$type = $row['docType'];
			break;	
		}	
		$res->close();
	}	
	$sql = "SELECT id, uploadedTime, updatedTime, deleted, docType, docStatusUpload, docStatusReview, docStatusComplete, docStatusNote, 
				   userId, userName, participantId, participantName, ";
//	if (!strcasecmp ($type, "EOB"))
		$sql .= "insurerId, insurerName, insurancePlanId, insurancePlanName, indivDeductPaid, familyDeductPaid ";
	$sql .= " imageId FROM docs WHERE deleted = 0 AND id = ".$docid;
	if (!empty($userId))	
		$sql .= " AND userId = ".$userId;
	if (!empty($participantId))	
		$sql .= " AND participantId = ".$participantId;
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
	$docsDetailResJSON = json_encode ($docsDetailRes);
var_dump($docsDetailRes, $docsDetailResJSON);
	return $docsDetailResJSON;	
}

function get_doc_items($dbname, $userId, $participantId, $docid){
	echo("Started get_doc_items ...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);

	$sql = "SELECT id, docType FROM docs WHERE deleted = 0 AND id = ".$docid;
	$res = $mysqli->query($sql);
	$type = "";
	if (!($res === false)) {
		while ($row = $res->fetch_assoc()) {	
			$type = $row['docType'];
			break;	
		}	
		$res->close();
	}	
	$sql = "SELECT id, uploadedTime, updatedTime, deleted, docItemType, docId, docType, userId, userName, participantId, participantName"; 
//	if (!strcasecmp ($type, "EOB"))
		$sql .= ", insurerId, insurerName, insurancePlanId, insurancePlanName";
	$sql .= ", providerPNI, providerName, serviceDate, placeOfService, codeType, code, codeMod, codeQty, codeDescr, codeAltDescr, amountBilled ";
//	if (!strcasecmp ($type, "EOB"))
		$sql .= ", amountExcluded, amountAllowed, coInsAmount, coPayAmount, particPaid, excluded, exclusionCode, exclusionExplan";
	$sql .= " FROM docitems WHERE deleted = 0 AND docId = ".$docid;
	if (!empty($userId))
		$sql .= " AND userId = ".$userId;
	if (!empty($participantId))	
		$sql .= " AND participantId = ".$participantId;
	$res = $mysqli->query($sql);
	$docItemRes = array();
	if (!($res === false)) {
		while ($row = $res->fetch_assoc()) {	
			$docItemRes[] = $row;	
		}	
		$res->close();
	}	

// Close connection
	$mysqli->close();
	$docItemResJSON = json_encode ($docItemRes);
var_dump($docItemRes, $docItemResJSON);
	return $docItemResJSON;	
}

function get_home_page_texts($dbname){
	echo("Started get_home_page_texts ...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);

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
	$homePageTextResJSON = json_encode ($homePageTextRes);
var_dump($homePageTextRes, $homePageTextResJSON);
	return $homePageTextResJSON;	
}

function get_glendor_snapshot($dbname, $userId, $participantId, $eobOnly){
	echo("Started get_glendor_snapshot ...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);

	$snapshotRes = array();
	$sql = "SELECT * FROM docs WHERE deleted = 0";
	if (!empty($userId))	
		$sql .= " AND userId = ".$userId;
	else 
		die("ERROR: userId should be nonempty");
	if (!empty($participantId))	
		$sql .= " AND participantId = ".$participantId;
	if (!empty($eobOnly))	
		$sql .= " AND docType = 'EOB'";
	$res = $mysqli->query($sql);
	$tot_uploaded = 0;
	$tot_completed = 0;
	$deduct = array();
	$count = 0;
	if (!($res === false)) {
		while ($row = $res->fetch_assoc()) {
			if (!empty($row['docStatusUpload']))
				$tot_uploaded ++;
			if (!empty($row['docStatusComplete']))
				$tot_completed ++;
			if (!isset($deduct[$row['participantId']]))
				$deduct[$row['participantId']] = array();
			if (!isset($deduct[$row['participantId']][$row['insurerId']]))
				$deduct[$row['participantId']][$row['insurerId']] = array();
			if (!isset($deduct[$row['participantId']][$row['insurerId']][$row['insurancePlanId']])) {
				$deduct[$row['participantId']][$row['insurerId']][$row['insurancePlanId']] = array();
				if (!isset($deduct[$row['participantId']][$row['insurerId']][$row['insurancePlanId']]['docs'])) {
					$deduct[$row['participantId']][$row['insurerId']][$row['insurancePlanId']]['docs'] = array();
					$count = 0;
				}	
				$deduct[$row['participantId']][$row['insurerId']][$row['insurancePlanId']]['docs'][$count]['docId'] = $row['id']; 
				$deduct[$row['participantId']][$row['insurerId']][$row['insurancePlanId']]['docs'][$count]['timestamp'] = strtotime($row['issuedDate']); 
				$deduct[$row['participantId']][$row['insurerId']][$row['insurancePlanId']]['docs'][$count]['paid'] = $row['indivDeductPaid']; 
				$count ++;
			}	
		}	
		$snapshotRes['docs_uploded'] = $tot_uploaded;
		$snapshotRes['docs_completed'] = $tot_completed;
		$snapshotRes['docs_completion_perc'] = 0;
		if ($tot_uploaded > 0)
			$snapshotRes['docs_completion_perc'] = $tot_completed * 100 / $tot_uploaded;

		foreach ($deduct as $key1 => $ded) {
			foreach ($ded as $key2 => $ins) {
				foreach ($ins as $key3 => $plan) {
					$timestamp = 0;
					foreach ($plan['docs'] as $doc) {
						if ($timestamp > $doc['timestamp'])
							continue;
						$timestamp = $doc['timestamp'];
						$paid = $doc['paid']; 
					}
					$deduct[$key1][$key2][$key3]['paid'] = $paid;
				}
			}
		}	
		$snapshotRes['deduct'] = array();
		$count = 0;
		foreach ($deduct as $key1 => $ded) {
			foreach ($ded as $key2 => $ins) {
				foreach ($ins as $key3 => $plan) {
					$sql = "SELECT userId, userName, participantId, participantName, insurerId, insurerName, insurancePlanId, insurancePlanName, deductInNetworkIndiv 
							FROM particinsplans 
							WHERE deleted = 0";
					$sql .= " AND userId = ".$userId;
					$sql .= " AND participantId = ".$key1;
					$sql .= " AND insurerId = ".$key2;
					$sql .= " AND insurancePlanId = ".$key3;
					$res1 = $mysqli->query($sql);
					if (!($res1 === false)) {
						while ($row = $res1->fetch_assoc()) {
							$snapshotRes['deduct'][$count]['userId'] = $row['userId'];
							$snapshotRes['deduct'][$count]['participantId'] = $row['participantId'];
							$snapshotRes['deduct'][$count]['participantName'] = $row['participantName'];
							$snapshotRes['deduct'][$count]['insurerId'] = $row['insurerId'];
							$snapshotRes['deduct'][$count]['insurerName'] = $row['insurerName'];
							$snapshotRes['deduct'][$count]['insurancePlanId'] = $row['insurancePlanId'];
							$snapshotRes['deduct'][$count]['insurancePlanName'] = $row['insurancePlanName'];
							$snapshotRes['deduct'][$count]['deductible'] = $row['deductInNetworkIndiv'];
							$snapshotRes['deduct'][$count]['paid'] = $plan['paid'];
							$snapshotRes['deduct'][$count]['deduct_paid_percent'] = 0;
							if ($snapshotRes['deduct'][$count]['deductible'] > 0)
								$snapshotRes['deduct_paid_percent'] = $snapshotRes['deduct'][$count]['paid'] * 100 / $snapshotRes['deduct'][$count]['deductible'];
							$count ++;
							break;
						}
						$res1->close();
					}	
				}
			}
		}
		$res->close();
	}	

// Close connection
	$mysqli->close();

	$snapshotResJSON = json_encode ($snapshotRes);
var_dump($snapshotRes, $snapshotResJSON);
	return $snapshotResJSON;	
}

function get_notes($dbname, $userId, $participantId, $docId){
	echo("Started get_notes ...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);

	if (empty($userId))
		die("ERROR: userId should be nonempty");
	if (empty($docId))
		die("ERROR: docId should be nonempty");
	
	$sql = "SELECT * FROM notes INNER JOIN docs ON notes.userId = docs.userId";
	if (!empty($participantId))	
		$sql .= " AND notes.participantId = docs.participantId";
	$sql .= " WHERE notes.deleted = 0 AND docs.deleted = 0 AND docs.docStatusComplete = ''";
	if (!empty($docId))	
		$sql .= " AND docs.id = ".$docId;
	$res = $mysqli->query($sql);
	$noteRes = array();
	if(!($res === false)) {
		$count = 0;
		while ($row = $res->fetch_assoc()) {
			$timestamp = $row['uploadedTime'];
			if ($timestamp < $row['updatedTime'])
				$timestamp = $row['updatedTime'];
			$noteRes[$count]['timestamp'] = $timestamp;	
			$noteRes[$count]['noteText'] = $row['noteText'];	
		}	
		$res->close();
	}	

// Close connection
	$mysqli->close();
	$noteResJSON = json_encode ($noteRes);
var_dump($noteRes, $noteResJSON);
	return $noteResJSON;	
}

function get_partic_ins_plans($dbname, $userId, $participantId){
	echo("Started get_partic_ins_plans ...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);

	$sql = "SELECT DISTINCT participantId, participantName, insurerId, insurerName, insurancePlanId, insurancePlanName, primaryInsPlan FROM particinsplans WHERE deleted = 0";
	if (!empty($userId))	
		$sql .= " AND userId = ".$userId;
	else 
		die("ERROR: userId should be nonempty");
	if (!empty($participantId))	
		$sql .= " AND participantId = ".$participantId;
	$sql .= " ORDER BY participantId DESC";
var_dump($sql);	
	$res = $mysqli->query($sql);
	$particInsPlanRes = array();
	
	while ($row = $res->fetch_assoc()) {
		$particInsPlanRes[] = $row;	
	}
	$res->close();

// Close connection
	$mysqli->close();

	$particInsPlanResJSON = json_encode ($particInsPlanRes);
var_dump($particInsPlanRes, $particInsPlanResJSON);
	return $particInsPlanResJSON;	
}

function get_participants($dbname, $userId, $participantId){
	echo("Started get_participants ...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);
	$sql = "SELECT id, participantName, gender, age, relatToUser FROM participants WHERE deleted = 0";
	if (!empty($userId))	
		$sql .= " AND userId = ".$userId;
	else 
		die("ERROR: userId should be nonempty");
	if (!empty($participantId))	
		$sql .= " AND id = ".$participantId;
	$sql .= " ORDER BY id ASC";
var_dump($sql);	
	$res = $mysqli->query($sql);
	$participantRes = array();
	if(!($res === false)) {
		while ($row = $res->fetch_assoc()) {
			$participantRes[] = $row;	
		}
		$res->close();
	}
// Close connection
	$mysqli->close();

	$participantResJSON = json_encode ($participantRes);
var_dump($participantRes, $participantResJSON);
	return $participantResJSON;	
}

function get_particproviders($dbname, $userId, $participantId){
	echo("Started get_particproviders ...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);
	$sql = "SELECT id, uploadedTime, updatedTime, providerType, providerPNI, providerLastName, providerFirstName, providerMiddleName, providerSpecialty, providerAddr,
				   providerCountyName, providerWebsite, providerEmail, providerPhone, providerFax FROM particproviders WHERE deleted = 0";
	if (!empty($userId))	
		$sql .= " AND userId = ".$userId;
	else 
		die("ERROR: userId should be nonempty");
	if (!empty($participantId))	
		$sql .= " AND id = ".$participantId;
	$sql .= " ORDER BY id ASC";
var_dump($sql);	
	$res = $mysqli->query($sql);
	$particProviderRes = array();
	if(!($res === false)) {
		while ($row = $res->fetch_assoc()) {
			$particProviderRes[] = $row;	
		}
		$res->close();
	}
// Close connection
	$mysqli->close();

	$particProviderResJSON = json_encode ($particProviderRes);
var_dump($particProviderRes, $particProviderResJSON);
	return $particProviderResJSON;	
}

function log_new_record ($dbname, $tableName, $record){
	echo("Started log_new_record ...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);
	foreach ($record as $rkey => $r) {
		$sql = "INSERT INTO logs (uploadedTime, tableName, recordId, fieldName, action, oldValue, newValue) VALUES
								 ('".$record['uploadedTime']."', '".$tableName."', '".$record['id']."', '".$rkey."', 'new', '', '".$r."')"; 
var_dump($record, $sql);	
		$res = $mysqli->query($sql);
		if($res === false)
			die("ERROR: Could not execute $sql. " . $mysqli->error);
	}	
// Close connection
	$mysqli->close();
}

function log_mod_record ($dbname, $tableName, $recordNew, $recordOld){
	echo("Started log_mod_record ...\n");
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);
var_dump($dbname, $tableName, $recordNew, $recordOld);	
//die;
	foreach ($recordNew as $rkey => $r) {
		$sql = "INSERT INTO logs (updatedTime, tableName, recordId, fieldName, action, oldValue, newValue) VALUES
								 ('".$recordNew['updatedTime']."', '".$tableName."', '".$recordNew['id']."', '".$rkey."', 'mod', '".$recordOld[$rkey]."', '".$r."')"; 
var_dump($rkey, $r, $recordNew['updatedTime'], $sql);	
die;
		$res = $mysqli->query($sql);
		if($res === false)
			die("ERROR: Could not execute $sql. " . $mysqli->error);
	}	
//die;
// Close connection
	$mysqli->close();
}

function add_participant ($dbname, $userId, $participantJSON){
	echo("Started add_participant ...\n");
	$participant = json_decode($participantJSON, true);
	
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);
	$uploadedTime = time();	
	$sql = "SELECT id, userName FROM users WHERE deleted = 0 AND id = ".$userId;
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
		('".$uploadedTime."', '', '', '', '".$userId."', '".$userName."', '".$participant['participantName']."', '".$participant['gender']."', '".$participant['age']."', '".$participant['relatToUser']."', '".$participant['particPictFilename']."')"; 
var_dump($participant, $sql);	
		
	$res = $mysqli->query($sql);
	if($res === false)
		die("ERROR: Could not execute $sql. " . $mysqli->error);
	$participantId = $mysqli->insert_id;
	$sql = "SELECT * FROM participants WHERE deleted = 0 AND id = ".$participantId;
var_dump($sql);	
	$res = $mysqli->query($sql);
	while ($record = $res->fetch_assoc()) {	
		break;	
	}	
	$res->close();
// Close connection
	$mysqli->close();
	log_new_record ($dbname, $tableName, $record);
var_dump($participantId);
	return $participantId;	
}

function mod_participant ($dbname, $userId, $participantId, $participantJSON){
	echo("Started mod_participant ...\n");
	$participant = json_decode($participantJSON, true);
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);
		
	$sql = "SELECT * FROM participants WHERE deleted = 0 AND id = ".$participantId;
var_dump($sql);	
	$res = $mysqli->query($sql);
	$participantOld = array();
	if (!($res === false)) {
		while ($participantOld = $res->fetch_assoc()) {	
			break;	
		}	
		$res->close();
	}	
	$participant['updatedTime'] = time();	
	$participant['id'] = $participantId;	
	$sql = "UPDATE participants SET"; 
	foreach ($participant as $fieldname=>$fieldvalue) {
		$sql .= " ".$fieldname."='".$fieldvalue."',";	
	}	
	$sql = preg_replace ('/,\s*$/', '', $sql);
	$sql = sprintf ("%s WHERE userId='%s' AND id='%s'", $sql, $userId, $participantId);
var_dump($sql);	
	$res = $mysqli->query($sql);
	if($res === false)
		die("ERROR: Could not execute $sql. " . $mysqli->error);
// Close connection
	$mysqli->close();
	log_mod_record ($dbname, 'participants', $participant, $participantOld);
var_dump($participant);
}

function add_partic_ins_plan ($dbname, $userId, $participantId, $particInsPlanJSON){
	echo("Started add_partic_ins_plan ...\n");
	$plan = json_decode($particInsPlanJSON, true);
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);
	$uploadedTime = time();	
	$sql = "SELECT userName, participantName FROM participants WHERE deleted = 0 AND userid = ".$userId." AND id = ".$participantId;
	$res = $mysqli->query($sql);
	$userName = "";
	$participantName = "";
	while ($row = $res->fetch_assoc()) {	
		$userName = $row['userName'];
		$participantName = $row['participantName'];
		break;	
	}	
	$res->close();
	$sql = "SELECT id, insurerId, insurerName, insurancePlanId, insurancePlanName FROM insuranceplans 
			WHERE deleted = 0 AND insurerName = '".$plan['insurerName']."' AND insurancePlanName = '".$plan['insurancePlanName']."'";
	$res = $mysqli->query($sql);
var_dump($plan, $sql, $res);	
	$insurerId = "";
	$insurancePlanId = "";
	if(!($res === false)) {
		while ($row = $res->fetch_assoc()) {	
			$insurerId = $row['insurerId'];
			$insurancePlanId = $row['id'];
			break;	
		}	
		$res->close();
	}	
	
	$sql = "INSERT INTO particinsplans (uploadedTime, updatedTime, deleted, insurancePlanType, userId, userName, participantId, participantName, insurerId, insurerName, 
										insurancePlanId, insurancePlanName, primaryInsPlan, startDate, endDate, monthlyPremium, 
										deductInNetworkFamily, deductInNetworkIndiv, deductOutNetworkFamily, deductOutNetworkIndiv,
										maxOopInNetworkFamily, maxOopInNetworkIndiv, maxOopOutNetworkFamily, maxOopOutNetworkIndiv, deductAppliedToOop) VALUES
									   ('".$uploadedTime."', '', '', '".$plan['particPlanType']."', '".$userId."', '".$userName."', '".$participantName."', '".$participantName."',
									    '".$insurerId."', '".$plan['insurerName']."', '".$insurancePlanId."', '".$plan['insurancePlanName']."',
										'".$plan['primaryInsPlan']."', '".$plan['startDate']."', '".$plan['endDate']."', '".$plan['monthlyPremium']."',
										'".$plan['deductInNetworkFamily']."', '".$plan['deductInNetworkIndiv']."', '".$plan['deductOutNetworkFamily']."', '".$plan['deductOutNetworkIndiv']."',
										'".$plan['maxOopInNetworkFamily']."', '".$plan['maxOopInNetworkIndiv']."', '".$plan['maxOopOutNetworkFamily']."', '".$plan['maxOopOutNetworkIndiv']."',
										'".$plan['deductAppliedToOop']."')"; 
var_dump($plan, $sql);	
		
	$res = $mysqli->query($sql);
	if($res === false)
		die("ERROR: Could not execute $sql. " . $mysqli->error);
	$particinsplanId = $mysqli->insert_id;
	$sql = "SELECT * FROM particinsplans WHERE deleted = 0 AND id = ".$particinsplanId;
var_dump($sql);	
	$res = $mysqli->query($sql);
	while ($record = $res->fetch_assoc()) {	
		break;	
	}	
	$res->close();
// Close connection
	$mysqli->close();
	log_new_record ($dbname, $tableName, $record);
var_dump($particinsplanId);
	return $particinsplanId;	
}

function mod_partic_ins_plan ($dbname, $userId, $particInsPlanId, $particInsPlanJSON){
	echo("Started mod_partic_ins_plan ...\n");
	$plan = json_decode($particInsPlanJSON, true);
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);
		
	$sql = "SELECT * FROM particinsplans WHERE deleted = 0 AND id = ".$particInsPlanId;
var_dump($sql);	
	$res = $mysqli->query($sql);
	$particInsPlanOld = array();
	if(!($res === false)) {
		while ($particInsPlanOld = $res->fetch_assoc()) {	
			break;	
		}	
		$res->close();
	}	
	$plan['updatedTime'] = time();	
	$plan['id'] = $particInsPlanId;	

var_dump($sql, $plan);
	$sql = "UPDATE particinsplans SET "; 
	foreach ($plan as $fieldname=>$fieldvalue) {
		$sql .= " ".$fieldname."='".$fieldvalue."',";	
var_dump($fieldname,$fieldvalue);		
		
	}	
	$sql = preg_replace ('/,\s*$/', '', $sql);
	$sql = sprintf ("%s WHERE userId = '%s' AND id = '%s'", $sql, $userId, $particInsPlanId);
var_dump($sql, $plan);	
	$res = $mysqli->query($sql);
	if($res === false)
		die("ERROR: Could not execute $sql. " . $mysqli->error);
// Close connection
	$mysqli->close();
	log_mod_record ($dbname, 'particinsplans', $plan, $particInsPlanOld);
var_dump($partinsplan);
}

function add_partic_provider ($dbname, $userId, $participantId, $particProviderJSON){
	echo("Started add_partic_provider ...\n");
	$provider = json_decode($particProviderJSON, true);
	
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);
	$uploadedTime = time();	
	if (empty($userId))	
		die("ERROR: userId should be nonempty");
	if (empty($participantId))	
		die("ERROR: userId should be nonempty");
	$sql = "SELECT userName, participantName FROM participants WHERE deleted = 0 AND userId = ".$userId." AND id = ".$participantId;
	$res = $mysqli->query($sql);
	$userName = "";
	$participantName = "";
	if(!($res === false)) {
		while ($row = $res->fetch_assoc()) {	
			$userName = $row['userName'];
			$participantName = $row['participantName'];
			break;	
		}	
		$res->close();
	}	
	$sql = "INSERT INTO particproviders (uploadedTime, updatedTime, deleted, providerType, userId, userName, participantId, participantName, providerLastName, 
										 providerFirstName, providerMiddleName, providerSpecialty) VALUES
									   ('".$uploadedTime."', '', '', '".$provider['providerType']."', '".$userId."', '".$userName."', '".$participantId."', '".$participantName."',
									    '".$provider['providerLastName']."', '".$provider['providerFirstName']."', '".$provider['providerMiddleName']."', '".$provider['providerSpecialty']."')"; 
var_dump($provider, $sql);	
	
	$res = $mysqli->query($sql);
	if($res === false)
		die("ERROR: Could not execute $sql. " . $mysqli->error);
	$particProviderId = $mysqli->insert_id;
	$sql = "SELECT * FROM particproviders WHERE deleted = 0 AND id = ".$particProviderId;
var_dump($sql);	
	$res = $mysqli->query($sql);
	while ($record = $res->fetch_assoc()) {	
		break;	
	}	
	$res->close();
// Close connection
	$mysqli->close();
	log_new_record ($dbname, 'particproviders', $record);
var_dump($particProviderId);
	return $particProviderId;	
}

function mod_partic_provider ($dbname, $userId, $particProviderId, $particProviderJSON){
	echo("Started mod_partic_ins_plan ...\n");
	$provider = json_decode($particProviderJSON, true);
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);
		
	$sql = "SELECT * FROM particproviders WHERE deleted = 0 AND id = ".$particProviderId;
var_dump($sql);	
	$res = $mysqli->query($sql);
	$particProviderOld = array();
	if(!($res === false)) {
		while ($particProviderOld = $res->fetch_assoc()) {	
			break;	
		}	
		$res->close();
	}	
	$provider['updatedTime'] = time();	
	$provider['id'] = $particProviderId;	
	$sql = "UPDATE particproviders SET"; 
	foreach ($provider as $fieldname=>$fieldvalue) {
		$sql .= " ".$fieldname."='".$fieldvalue."',";	
	}	
	$sql = preg_replace ('/,\s*$/', '', $sql);
	$sql = sprintf ("%s WHERE userId='%s' AND id='%s'", $sql, $userId, $particProviderId);
var_dump($sql);	
	$res = $mysqli->query($sql);
	if($res === false)
		die("ERROR: Could not execute $sql. " . $mysqli->error);
// Close connection
	$mysqli->close();
	log_mod_record ($dbname, 'particproviders', $provider, $particProviderOld);
var_dump($provider);
}

function add_note($dbname, $userId, $participantId, $docId, $noteJSON){
	echo("Started add_note ...\n");
	$note = json_decode($noteJSON, true);
//var_dump($dbname, $userId, $participantId, $docId, $noteJSON);	
	
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);

	if (empty($userId))
		die("ERROR: userId should be nonempty");
	if (empty($participantId))
		die("ERROR: participantId should be nonempty");
	if (empty($docId))
		die("ERROR: docId should be nonempty");

	$uploadedTime = time();	
	$sql = "SELECT userName, participantName FROM participants WHERE deleted = 0 AND userid = ".$userId." AND id = ".$participantId;
	$res = $mysqli->query($sql);
	$userName = "";
	$participantName = "";
	if(!($res === false)) {
		while ($row = $res->fetch_assoc()) {	
			$userName = $row['userName'];
			$participantName = $row['participantName'];
			break;	
		}	
		$res->close();
	}	

	$sql = "INSERT INTO notes (uploadedTime, updatedTime, deleted, noteType, userId, userName, participantId, participantName, insurerId, insurerName, 
										insurancePlanId, insurancePlanName, tableName, recordId, noteText) VALUES
									   ('".$uploadedTime."', '', '', '".$note['noteType']."', '".$userId."', '".$userName."', '".$participantId."', '".$participantName."',
									    '".$note['insurerId']."', '".$note['insurerName']."', '".$note['insurancePlanId']."', '".$note['insurancePlanName']."', '"."docs"."',
										'".$docId."', '".$note['noteText']."')"; 
var_dump($note, $sql);	
	
	$res = $mysqli->query($sql);
	if($res === false)
		die("ERROR: Could not execute $sql. " . $mysqli->error);
	$noteId = $mysqli->insert_id;
	$sql = "SELECT * FROM notes WHERE deleted = 0 AND id = ".$noteId;
var_dump($sql);	
	$res = $mysqli->query($sql);
	while ($record = $res->fetch_assoc()) {	
		break;	
	}	
	$res->close();
// Close connection
	$mysqli->close();
	log_new_record ($dbname, 'notes', $record);
var_dump($noteId);
	return $noteId;	
}

function mod_note ($dbname, $userId, $noteId, $noteJSON){
	echo("Started mod_note ...\n");
	$note = json_decode($noteJSON, true);
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);
		
	$sql = "SELECT * FROM notes WHERE deleted = 0 AND id = ".$noteId;
var_dump($sql);	
	$res = $mysqli->query($sql);
	$noteOld = array();
	if(!($res === false)) {
		while ($noteOld = $res->fetch_assoc()) {	
			break;	
		}	
		$res->close();
	}	
	$note['updatedTime'] = time();	
	$note['id'] = $noteId;	
	$sql = "UPDATE notes SET"; 
	foreach ($note as $fieldname=>$fieldvalue) {
		$sql .= " ".$fieldname."='".$fieldvalue."',";	
	}	
	$sql = preg_replace ('/,\s*$/', '', $sql);
	$sql = sprintf ("%s WHERE userId='%s' AND id='%s'", $sql, $userId, $noteId);
var_dump($sql);	
	$res = $mysqli->query($sql);
	if($res === false)
		die("ERROR: Could not execute $sql. " . $mysqli->error);
// Close connection
	$mysqli->close();
	log_mod_record ($dbname, 'notes', $note, $noteOld);
var_dump($note);
}

function mod_doc ($dbname, $userId, $docId, $docJSON){
	echo("Started mod_doc ...\n");
	$doc = json_decode($docJSON, true);
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);
		
	$sql = "SELECT * FROM docs WHERE deleted = 0 AND id = ".$docId;
var_dump($sql);	
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
	foreach ($doc as $fieldname=>$fieldvalue) {
		$sql .= " ".$fieldname."='".$fieldvalue."',";	
	}	
	$sql = preg_replace ('/,\s*$/', '', $sql);
	$sql = sprintf ("%s WHERE userId='%s' AND id='%s'", $sql, $userId, $docId);
var_dump($sql);	
	$res = $mysqli->query($sql);
	if($res === false)
		die("ERROR: Could not execute $sql. " . $mysqli->error);
// Close connection
	$mysqli->close();
	log_mod_record ($dbname, 'docs', $doc, $docOld);
var_dump($doc);
}

function mod_docitem ($dbname, $userId, $docitemId, $docitemJSON){
	echo("Started mod_docitem ...\n");
	$docitem = json_decode($docitemJSON, true);
// Attempt MySQL server connection. Assuming you are running MySQL server with default setting (user 'root' with no password) 
	$mysqli = new mysqli("localhost", "root", "hercules15", $dbname);
// Check connection
	if($mysqli === false)
		die("ERROR: Could not connect. " . $mysqli->connect_error);
		
	$sql = "SELECT * FROM docitems WHERE deleted = 0 AND id = ".$docitemId;
var_dump($sql);	
	$res = $mysqli->query($sql);
	$docitemOld = array();
	if (!($res === false)) {
		while ($docitemOld = $res->fetch_assoc()) {	
			break;	
		}	
		$res->close();
	}	
	$docitem['updatedTime'] = time();	
	$docitem['id'] = $docitemId;	
var_dump($docitem, $dociteOld);	
	$sql = "UPDATE docitems SET"; 
	foreach ($docitem as $fieldname=>$fieldvalue) {
		$sql .= " ".$fieldname."='".$fieldvalue."',";	
	}	
	$sql = preg_replace ('/,\s*$/', '', $sql);
	$sql = sprintf ("%s WHERE userId='%s' AND id='%s'", $sql, $userId, $docitemId);
var_dump($sql);	
	$res = $mysqli->query($sql);
	if($res === false)
		die("ERROR: Could not execute $sql. " . $mysqli->error);
// Close connection
	$mysqli->close();
	log_mod_record ($dbname, 'docitems', $docitem, $docitemOld);
var_dump($docitem);
}

function main() {
// main function
	
echo ("came to main\n");

	global $cfg;
//var_dump($cfg);
	$action = $cfg['action'];
	if ($action == "build_db_schema")
		build_db_schema($cfg['dbname']);
	if ($action == "insert_sample_records")
		insert_sample_records($cfg['dbname']);
	if ($action == "get_doc_list")
		get_doc_list($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['year']);
	if ($action == "get_doc_details")
		get_doc_details($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['docid']);
	if ($action == "get_doc_items")
		get_doc_items($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['docid']);
	if ($action == "get_home_page_texts")
		get_home_page_texts($cfg['dbname']);
	if ($action == "get_glendor_snapshot")
		get_glendor_snapshot($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['eobOnly']);
	if ($action == "get_notes")
		get_notes($cfg['dbname'], $cfg['userId'], $cfg['participantId'], $cfg['docId']);
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
}

$cfg = array();
$cfg['action'] = $argv[1];

//echo ("came to DBProc\n");
//var_dump($cfg);
//die();
if ($cfg['action'] == "build_db_schema") {
	$cfg['dbname'] = $argv[2];
	if ($argc != 3) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php build_db_schema <dbname>");
	}
}
if ($cfg['action'] == "insert_sample_records") {
	$cfg['dbname'] = $argv[2];
	if ($argc != 3) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php insert_sample_records <dbname>");
	}
}
if ($cfg['action'] == "get_doc_list") {
	$cfg['dbname'] 			= $argv[2];
	$cfg['userId'] 			= $argv[3];
	$cfg['participantId'] 	= $argv[4];
	$cfg['year'] 			= $argv[5];
	if ($argc != 6) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php get_doc_list <dbname> <userId> <participantId> <year>");
	}
}
if ($cfg['action'] == "get_doc_details") {
	$cfg['dbname'] 			= $argv[2];
	$cfg['userId'] 			= $argv[3];
	$cfg['participantId'] 	= $argv[4];
	$cfg['docid'] 			= $argv[5];
	if ($argc != 6) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php get_doc_details <dbname> <userId> <participantId> <docid>");
	}
}
if ($cfg['action'] == "get_doc_items") {
	$cfg['dbname'] 			= $argv[2];
	$cfg['userId'] 			= $argv[3];
	$cfg['participantId'] 	= $argv[4];
	$cfg['docid'] 			= $argv[5];
	if ($argc != 6) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php get_doc_items <dbname> <userId> <participantId> <docid>");
	}
}
if ($cfg['action'] == "get_home_page_texts") {
	$cfg['dbname'] 			= $argv[2];
	if ($argc != 3) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php get_home_page_texts <dbname>");
	}
}
if ($cfg['action'] == "get_glendor_snapshot") {
	$cfg['dbname'] 			= $argv[2];
	$cfg['userId'] 			= $argv[3];
	$cfg['participantId'] 	= $argv[4];
	$cfg['eobOnly']			= $argv[5];
	if ($argc != 6) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php get_glendor_snapshot <dbname> <userId> <participantId> <eobOnly>");
	}
}
if ($cfg['action'] == "get_notes") {
	$cfg['dbname'] 			= $argv[2];
	$cfg['userId'] 			= $argv[3];
	$cfg['participantId'] 	= $argv[4];
	$cfg['docId']			= $argv[5];
	if ($argc != 6) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php get_notes <dbname> <userId> <participantId> <docid>");
	}
}
if ($cfg['action'] == "get_partic_ins_plans") {
	$cfg['dbname'] 			= $argv[2];
	$cfg['userId'] 			= $argv[3];
	$cfg['participantId'] 	= $argv[4];
	if ($argc != 5) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php get_partic_ins_plans <dbname> <userId> <participantId>");
	}
}
if ($cfg['action'] == "get_participants") {
	$cfg['dbname'] 			= $argv[2];
	$cfg['userId'] 			= $argv[3];
	$cfg['participantId'] 	= $argv[4];
	if ($argc != 5) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php get_participants <dbname> <userId> <participantId>");
	}
}
if ($cfg['action'] == "get_particproviders") {
	$cfg['dbname'] 			= $argv[2];
	$cfg['userId'] 			= $argv[3];
	$cfg['participantId'] 	= $argv[4];
	if ($argc != 5) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php get_particproviders <dbname> <userId> <participantId>");
	}
}
if ($cfg['action'] == "add_participant") {
	$cfg['dbname'] 			= $argv[2];
	$cfg['userId'] 			= $argv[3];
	$cfg['participantJSON']	= $argv[4];
	if ($argc != 5) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php add_participant <dbname> <userId> <participantJSON>");
	}
}
if ($cfg['action'] == "mod_participant") {
	$cfg['dbname'] 			= $argv[2];
	$cfg['userId'] 			= $argv[3];
	$cfg['participantId'] 	= $argv[4];
	$cfg['participantJSON']	= $argv[5];
	if ($argc != 6) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php mod_participant <dbname> <userId> <participantId> <participantJSON>");
	}
}
if ($cfg['action'] == "add_partic_ins_plan") {
	$cfg['dbname'] 				= $argv[2];
	$cfg['userId'] 				= $argv[3];
	$cfg['participantId'] 		= $argv[4];
	$cfg['particInsPlanJSON']	= $argv[5];
	if ($argc != 6) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php add_partic_ins_plan <dbname> <userId> <participantId> <particInsPlanJSON>");
	}
}
if ($cfg['action'] == "mod_partic_ins_plan") {
	$cfg['dbname'] 				= $argv[2];
	$cfg['userId'] 				= $argv[3];
	$cfg['particInsPlanId'] 	= $argv[4];
	$cfg['particInsPlanJSON']	= $argv[5];
	if ($argc != 6) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php mod_partic_ins_plan <dbname> <userId> <particInsPlanId> <particInsPlanJSON>");
	}
}
if ($cfg['action'] == "add_partic_provider") {
	$cfg['dbname'] 				= $argv[2];
	$cfg['userId'] 				= $argv[3];
	$cfg['participantId'] 		= $argv[4];
	$cfg['particProviderJSON']	= $argv[5];
	if ($argc != 6) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php add_partic_provider <dbname> <userId> <particInsPlanId> <particInsPlanJSON>");
	}
}
if ($cfg['action'] == "mod_partic_provider") {
	$cfg['dbname'] 				= $argv[2];
	$cfg['userId'] 				= $argv[3];
	$cfg['particProviderId'] 		= $argv[4];
	$cfg['particProviderJSON']	= $argv[5];
	if ($argc != 6) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php mod_partic_provider <dbname> <userId> <particProviderId> <particProviderJSON>");
	}
}
if ($cfg['action'] == "add_note") {
	$cfg['dbname'] 			= $argv[2];
	$cfg['userId'] 			= $argv[3];
	$cfg['participantId'] 	= $argv[4];
	$cfg['docId'] 			= $argv[5];
	$cfg['noteJSON']		= $argv[6];
	if ($argc != 7) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php add_note <dbname> <userId> <docId> <noteJSON>");
	}
}
if ($cfg['action'] == "mod_note") {
	$cfg['dbname'] 		= $argv[2];
	$cfg['userId'] 		= $argv[3];
	$cfg['noteId'] 		= $argv[4];
	$cfg['noteJSON']	= $argv[5];
	if ($argc != 6) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php mod_note <dbname> <userId> <noteId> <noteJSON>");
	}
}
if ($cfg['action'] == "mod_doc") {
	$cfg['dbname'] 		= $argv[2];
	$cfg['userId'] 		= $argv[3];
	$cfg['docId'] 		= $argv[4];
	$cfg['docJSON']	= $argv[5];
	if ($argc != 6) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php mod_doc <dbname> <userId> <docId> <docJSON>");
	}
}
if ($cfg['action'] == "mod_docitem") {
	$cfg['dbname'] 		= $argv[2];
	$cfg['userId'] 		= $argv[3];
	$cfg['docitemId']	= $argv[4];
	$cfg['docitemJSON']	= $argv[5];
	if ($argc != 6) {
		print ("DBProc\n");
		die ("Usage: php -f DBProc.php mod_docitem <dbname> <userId> <docitemId> <docitemJSON>");
	}
}

main();

?>
