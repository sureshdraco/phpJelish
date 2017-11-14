<?php
/**
 * Copyright 2007 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
require_once 'google/appengine/api/users/User.php';
  require_once 'google/appengine/api/users/UserService.php';

  use google\appengine\api\users\User;
  use google\appengine\api\users\UserService;
$db = 'glendor';
  $greeting_schema = <<<SCHEMA
CREATE TABLE IF NOT EXISTS greeting (
    id INT NOT NULL AUTO_INCREMENT,
    author VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    PRIMARY KEY (id)
)
SCHEMA;
 if (strpos(getenv('SERVER_SOFTWARE'), 'Development') === false) {
    $conn = mysqli_connect(null,
                           getenv('PRODUCTION_DB_USERNAME'),
                           getenv('PRODUCTION_DB_PASSWORD'),
                           null,
                           null,
                           getenv('PRODUCTION_CLOUD_SQL_INSTANCE'));
  } else {
    $conn = mysqli_connect(getenv('DEVELOPMENT_DB_HOST'), 
                           getenv('DEVELOPMENT_DB_USERNAME'),
                           getenv('DEVELOPMENT_DB_PASSWORD'));
  }
  if ($conn->connect_error) {
    die("Could not connect to database: $conn->connect_error " .
        "[$conn->connect_errno]");
  }

  if ($conn->query("CREATE DATABASE IF NOT EXISTS $db") === FALSE) {
    die("Could not create database: $conn->error [$conn->errno]");
  }

  if ($conn->select_db($db) === FALSE) {
    die("Could not select database: $conn->error [$conn->errno]");
  }