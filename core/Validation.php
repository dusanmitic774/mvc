<?php

class Validation
{
    public $errors = [];
    public $passed = false;

    /**
     * Checks if input matches the requirements.
     * If not matched errors variable is field with errors such that
     * key is a column name and a value is array of errors for that column.
     * Example:
     * [
     *     'fname' => [ 'fname is required', 'fname must be more than 2 characters'],
     *     'lname' => [ 'lname is required' ]
     * ]
     *
     * @param array $input
     * @param array $data
     *
     * @return bool Returns true if all requirements are met or false if not.
     */
    public function validate($input, $data)
    {
        foreach ($data as $field => $requirements) {
            foreach ($requirements as $requirement => $value) {

                if ( ! empty($input)) {
                    switch ($requirement) {
                        case 'required':
                            if (empty($input[$field]) & $value !== false) {
                                $this->addError($field, $field . ' is required');
                            }
                            break;
                        case 'max':
                            if (strlen($input[$field]) >= $value) {
                                $this->addError($field, $field . ' has to be less than ' . $value . ' characters');
                            }
                            break;
                        case 'min':
                            if (strlen($input[$field]) <= $value) {
                                $this->addError($field, $field . ' has to be more than ' . $value . ' characters');
                            }
                            break;
                        case 'unique':
                            $data = DB::getInstance()->select($value, [$field])->where([
                                [
                                    $field,
                                    '=',
                                    $input[$field]
                                ]
                            ])
                                      ->get();

                            if ( ! empty($data) && $data[0]->$field == $input[$field]) {
                                $this->addError($field, $field . ' already exists');
                            }
                    }
                }
            }
        }

        if (empty($this->errors())) {
            return true;
        }

        return false;
    }

    public function addError($field, $error)
    {
        $this->errors[$field][] = $error;
    }

    public function errors()
    {
        return $this->errors;
    }
}
