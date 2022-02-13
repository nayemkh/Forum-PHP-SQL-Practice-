<?php

namespace Registration;

class Controller
{
    public $fields = [
        'username' => [
            'type' => 'text',
            'placeholder' => 'Username (at least 5 characters long)',
            'min_chars' => 5,
            'sanitised_name' => 'username',
        ],
        'password' => [
            'type' => 'password',
            'placeholder' => 'Password (at least 6 characters long)',
            'min_chars' => 6,
            'sanitised_name' => 'password',
        ],
        'email' => [
            'type' => 'email',
            'placeholder' => 'Email Address',
            'min_chars' => 1,
            'sanitised_name' => 'email address'
        ],
    ];

    public $errors = [];

    public function processSubmission()
    {
        $submitted = $_POST['submit'] ?? '';

        if ($submitted) {
            $fields = $this->fields;
            if (is_array($fields) && !empty($fields)) {
                $this->submissionData = [];
                foreach ($fields as $name => $field) {
                    $value = htmlspecialchars($_POST[$name]);
                    $submission = [
                        'name' => $name,
                        'sanitised_name' => $field['sanitised_name'],
                        'value' => $value,
                        'min_chars' => $field['min_chars'],
                        'chars' => strlen(trim($value)),
                    ];
                    $this->submissionData[] = $submission;
                    $submissionData = $this->submissionData;
                }
                $this->validate($submissionData);
            }
        }
    }

    public function validate($submissionData)
    {
        if (is_array($submissionData) && !empty($submissionData)) {
            foreach ($submissionData as $submission) {
                $error = '';
                $errorMsg = '';
                $empty = $submission['chars'] === 0 ? 'true' : '';
                // Perform extra validation if fields aren't empty
                if ($empty) {
                    $errorMsg = sprintf('The %s field cannot be empty', $submission['sanitised_name']);
                } else {
                    if ($submission['chars'] < $submission['min_chars']) {
                        $errorMsg = sprintf('Your %s needs to be at least %s characters long', $submission['sanitised_name'], $submission['min_chars']);
                    }
                }
                if ($errorMsg) {
                    $error = [
                        'field' => $submission['name'],
                        'message' => $errorMsg,
                    ];
                    $this->errors[] = $error;
                }
            }
        }
    }

    public function run()
    {
        $this->processSubmission();
    }
}
