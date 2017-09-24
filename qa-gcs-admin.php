<?php
/*
Setting up the admin page options.
*/
class qa_gcs_admin_config
{
  function admin_form(&$qa_content)
  {
    $saved=false;

    if (qa_clicked('gcs_save_button')) {
      qa_opt('gcs_api_on', (bool) qa_post_text('gcs_api_on_cb'));
      qa_opt('gcs_api_key_location', qa_post_text('gcs_api_key_location_field'));
      qa_opt('gcs_project_id', qa_post_text('gcs_project_id_field'));
      qa_opt('gcs_bucket_name', qa_post_text('gcs_bucket_name_field'));
      $saved=true;
    }

    return array(
      'ok' => $saved ? 'Google Cloud Storage(GCS) API settings saved' : null,

      'fields' => array(
        array(
          'label' => 'Do you want to enable upload to Google Cloud Storage (GCS)?',
          'type' => 'checkbox',
          'value' => (bool)qa_opt('gcs_api_on'),
          'tags' => 'NAME="gcs_api_on_cb"',
        ),
        array(
          'label' => 'GCS API JSON: (Enter absolute location to the Service account key JSON file)',
          'value' => qa_html(qa_opt('gcs_api_key_location')),
          'tags' => 'name="gcs_api_key_location_field"',
        ),
        array(
          'label' => 'GCS Project ID: ',
          'value' => qa_html(qa_opt('gcs_project_id')),
          'tags' => 'name="gcs_project_id_field"',
        ),
        array(
          'label' => 'GCS Bucket Name: ',
          'value' => qa_html(qa_opt('gcs_bucket_name')),
          'tags' => 'name="gcs_bucket_name_field"',
        ),
      ),

      'buttons' => array(
        array(
          'label' => 'Save Changes',
          'tags' => 'name="gcs_save_button"',
        ),
      ),
    );
  }
}