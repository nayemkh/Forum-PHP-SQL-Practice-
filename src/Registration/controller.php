<?php

namespace Forum\Registration;

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

    public $messages = [
        'error' => [],
        'success' => []
    ];

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
                }
                $submissionData = $this->submissionData;
                $this->validate($submissionData);

                // Attempt insertion of data inside database if no errors
                if (is_array($this->messages['error']) && empty($this->messages['error'])) {
                    $connection = new \MySQLi('localhost', 'root', '', 'dev_forum');
                    if ($connection) {
                        if (is_array($submissionData) && !empty($submissionData)) {
                            $fields = [];
                            $values = [];
                            foreach ($submissionData as $submission) {
                                $fields[] = $submission['name'];
                                // Hash password field
                                if ($submission['name'] !== 'password') {
                                    $values[] = $connection->real_escape_string($submission['value']);
                                } else {
                                    $values[] = password_hash($connection->real_escape_string($submission['value']), PASSWORD_DEFAULT);
                                }
                            }
                            // Insert join date
                            $fields[] = 'joinDate';
                            $values[] = date('Y-m-d');
                        }

                        if (is_array($fields) && !empty($fields)) {
                            // Create necessary number of placeholder (?) / type (s) values
                            $fieldCount = count($fields);
                            $preparedVals = rtrim(str_repeat("?,", $fieldCount), ',');
                            $bindParams = str_repeat("s", $fieldCount);

                            // Split $fields var up for use in SQL query
                            $fields = implode(',', $fields);
                        }

                        // Prepared statement
                        $statement = mysqli_stmt_init($connection);
                        $query = "INSERT INTO Users ($fields) VALUES ($preparedVals)";

                        if (mysqli_stmt_prepare($statement, $query)) {
                            mysqli_stmt_bind_param($statement, $bindParams, ...$values);
                            mysqli_stmt_execute($statement);
                        }

                        // Check for any SQL errors
                        if (!mysqli_error($connection)) {
                            $this->messages['success'][] = 'Thank you for registering.';
                        } else {
                            $this->messages['error'][] = 'There was a problem with your registration, please contact a member of support.';
                        }
                    }
                }
            }
        }
    }

    public function validate($submissionData)
    {
        if (is_array($submissionData) && !empty($submissionData)) {
            foreach ($submissionData as $submission) {
                $text = '';
                $empty = $submission['chars'] === 0 ? 'true' : '';
                // Perform extra validation if fields aren't empty
                if ($empty) {
                    $text = sprintf('The %s field cannot be empty', $submission['sanitised_name']);
                } else {
                    if ($submission['chars'] < $submission['min_chars']) {
                        $text = sprintf('Your %s needs to be at least %s characters long', $submission['sanitised_name'], $submission['min_chars']);
                    }
                }
                if ($text) {
                    $this->messages['error'][] = $text;
                }
            }
        }
    }

    public function run()
    {
        $this->processSubmission();
    }
}
