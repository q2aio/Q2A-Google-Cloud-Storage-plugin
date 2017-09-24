<?php

if (!defined('QA_VERSION')) {
	header('Location: ../../');
	exit;
}

/*
// Register file to override the functions
// present in the file
*/
qa_register_plugin_overrides('qa-upload-override.php');

qa_register_plugin_module('module', 'qa-gcs-admin.php', 'qa_gcs_admin_config', 'Q2A Google Cloud Storage plugin');
