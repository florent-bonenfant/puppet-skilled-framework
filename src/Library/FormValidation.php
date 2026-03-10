<?php

namespace Globalis\PuppetSkilled\Library;

/**
 * Form Validation class compatible with CI4 runtime and legacy CI3 API usage.
 */
class FormValidation
{
    protected bool $ran = false;

    protected string $_error_prefix = '';

    protected string $_error_suffix = '';

    /**
     * @var array<string,array<string,mixed>>
     */
    protected array $_field_data = [];

    /**
     * @var array<string,string>
     */
    protected array $_error_array = [];

    /**
     * @var array<string,mixed>
     */
    public array $validation_data = [];

    public function set_error_delimiters(string $prefix = '', string $suffix = ''): self
    {
        $this->_error_prefix = $prefix;
        $this->_error_suffix = $suffix;
        return $this;
    }

    public function error_array(): array
    {
        return $this->_error_array;
    }

    public function error(string $field = '', string $prefix = '', string $suffix = ''): string
    {
        if ($field === '') {
            $first = reset($this->_error_array);
            if ($first === false) {
                return '';
            }
            return ($prefix !== '' ? $prefix : $this->_error_prefix) . $first . ($suffix !== '' ? $suffix : $this->_error_suffix);
        }

        if (!isset($this->_field_data[$field]['error']) || $this->_field_data[$field]['error'] === '') {
            return '';
        }

        return ($prefix !== '' ? $prefix : $this->_error_prefix)
            . $this->_field_data[$field]['error']
            . ($suffix !== '' ? $suffix : $this->_error_suffix);
    }

    public function set_value($field = '', $default = '')
    {
        if (!isset($this->_field_data[$field], $this->_field_data[$field]['postdata'])) {
            if ($field !== '' && array_key_exists($field, $this->validation_data)) {
                return $this->validation_data[$field];
            }

            $method = app()->input->method();
            $requestData = ($method === 'post') ? (array) app()->input->post() : (array) app()->input->get();
            if ($field !== '' && array_key_exists($field, $requestData)) {
                return $requestData[$field];
            }

            return $default;
        }

        return $this->_field_data[$field]['postdata'];
    }

    public function has_rule(string $field): bool
    {
        return isset($this->_field_data[$field]['rules']);
    }

    public function set_rules($field, $label = '', $rules = [], $errors = []): self
    {
        if (is_array($field)) {
            foreach ($field as $row) {
                if (!isset($row['field'], $row['rules'])) {
                    continue;
                }

                $rowLabel = isset($row['label']) ? $row['label'] : $row['field'];
                $rowErrors = (isset($row['errors']) && is_array($row['errors'])) ? $row['errors'] : [];
                $this->set_rules($row['field'], $rowLabel, $row['rules'], $rowErrors);
            }

            return $this;
        }

        if (!is_string($field) || $field === '' || empty($rules)) {
            return $this;
        }

        if (!is_array($rules)) {
            if (!is_string($rules)) {
                return $this;
            }
            $rules = preg_split('/\|(?![^\[]*\])/', $rules) ?: [];
        }

        $label = ($label === '') ? $field : $label;
        $indexes = [];

        if (($isArray = (bool) preg_match_all('/\[(.*?)\]/', $field, $matches)) === true) {
            sscanf($field, '%[^[][', $indexes[0]);
            for ($i = 0, $c = count($matches[0]); $i < $c; $i++) {
                if ($matches[1][$i] !== '') {
                    $indexes[] = $matches[1][$i];
                }
            }
        } else {
            $isArray = false;
        }

        $this->_field_data[$field] = [
            'field' => $field,
            'label' => $label,
            'rules' => $rules,
            'errors' => $errors,
            'is_array' => $isArray,
            'keys' => $indexes,
            'postdata' => null,
            'error' => '',
        ];

        return $this;
    }

    public function add_error($message, $field = null): self
    {
        $message = array_values((array) $message);
        if ($message === []) {
            return $this;
        }

        if ($field !== null && isset($this->_field_data[$field])) {
            $this->_field_data[$field]['error'] = $message[0];
        }

        if ($field !== null && isset($this->_field_data[$field]['field'])) {
            $this->_error_array[$field] = $message[0];
        } else {
            $this->_error_array[] = $message[0];
        }

        return $this;
    }

    public function set_select($field = '', $value = '', $default = false): string
    {
        if (!$this->ran()) {
            return ($default === true) ? ' selected="selected"' : '';
        }

        $fieldValue = $this->_field_data[$field]['postdata'] ?? '';
        $value = (string) $value;

        if (is_array($fieldValue)) {
            foreach ($fieldValue as $v) {
                if ($value === (string) $v) {
                    return ' selected="selected"';
                }
            }
            return '';
        }

        return (($fieldValue !== '' && $value !== '' && (string) $fieldValue === $value) ? ' selected="selected"' : '');
    }

    public function set_radio($field = '', $value = '', $default = false): string
    {
        if (!isset($this->_field_data[$field]['postdata'])) {
            return ($default === true) ? ' checked="checked"' : '';
        }

        $fieldValue = $this->_field_data[$field]['postdata'];
        $value = (string) $value;

        if (is_array($fieldValue)) {
            foreach ($fieldValue as $v) {
                if ($value === (string) $v) {
                    return ' checked="checked"';
                }
            }
            return '';
        }

        return (($fieldValue !== '' && $value !== '' && (string) $fieldValue === $value) ? ' checked="checked"' : '');
    }

    public function isRequired($fieldName): bool
    {
        return $this->has_rule($fieldName) && in_array('required', $this->_field_data[$fieldName]['rules'], true);
    }

    /**
     * Legacy callback compatibility: allows calling $validator->required($value)
     * from custom closures in controllers.
     */
    public function required($value): bool
    {
        return !($value === null || $value === '' || (is_array($value) && $value === []));
    }

    public function isValid(): bool
    {
        return $this->ran && $this->_error_array === [];
    }

    public function ran(): bool
    {
        return $this->ran;
    }

    public function run($group = ''): bool
    {
        $this->ran = false;
        $this->_error_array = [];

        $data = is_array($group) ? $group : [];
        if ($data === []) {
            $method = app()->input->method();
            $data = ($method === 'post') ? (array) app()->input->post() : (array) app()->input->get();
            if ($data === [] && $this->validation_data === []) {
                return false;
            }
        }
        $this->validation_data = array_merge($this->validation_data, $data);

        $this->ran = true;

        foreach ($this->_field_data as $field => &$metadata) {
            $value = $this->extractFieldValue($metadata, $data);
            $metadata['postdata'] = $value;

            foreach ($metadata['rules'] as $rule) {
                if ($this->evaluateRule($field, $metadata, $rule) === false) {
                    break;
                }
            }
        }

        return $this->isValid();
    }

    public function exist($str, $field): bool
    {
        return !$this->is_unique((string) $str, (string) $field);
    }

    protected function evaluateRule(string $field, array &$metadata, $rule): bool
    {
        if (is_string($rule)) {
            [$ruleName, $param] = $this->parseRule($rule);
            return $this->applyRule($field, $metadata, $ruleName, $param);
        }

        if (is_array($rule) && isset($rule[1]) && is_callable($rule[1])) {
            $result = call_user_func($rule[1], $metadata['postdata']);
            $ok = !($result === false || $result === null);
            if (!$ok) {
                $message = is_string($rule[0] ?? null) ? $rule[0] : 'VALIDATION_ERROR';
                $this->registerError($field, $metadata, $message);
            } elseif ($result !== true) {
                // CI3-compatible callback behavior: callbacks may return transformed value.
                $metadata['postdata'] = $result;
            }
            return $ok;
        }

        if (is_callable($rule)) {
            $result = call_user_func($rule, $metadata['postdata']);
            $ok = !($result === false || $result === null);
            if (!$ok) {
                $this->registerError($field, $metadata, 'VALIDATION_ERROR');
            } elseif ($result !== true) {
                $metadata['postdata'] = $result;
            }
            return $ok;
        }

        return true;
    }

    protected function applyRule(string $field, array &$metadata, string $rule, ?string $param): bool
    {
        $value = $metadata['postdata'];

        switch ($rule) {
            case 'trim':
                if (is_string($value)) {
                    $metadata['postdata'] = trim($value);
                }
                return true;

            case 'required':
                $ok = !($value === null || $value === '' || (is_array($value) && $value === []));
                if (!$ok) {
                    $this->registerError($field, $metadata, 'required');
                }
                return $ok;

            case 'max_length':
                $ok = mb_strlen((string) $value) <= (int) $param;
                if (!$ok) {
                    $this->registerError($field, $metadata, 'max_length', $param);
                }
                return $ok;

            case 'min_length':
                $ok = mb_strlen((string) $value) >= (int) $param;
                if (!$ok) {
                    $this->registerError($field, $metadata, 'min_length', $param);
                }
                return $ok;

            case 'matches':
                $other = $this->_field_data[$param]['postdata'] ?? $this->validation_data[$param] ?? null;
                $ok = (string) $value === (string) $other;
                if (!$ok) {
                    $this->registerError($field, $metadata, 'matches');
                }
                return $ok;

            case 'numeric':
                $ok = is_numeric($value);
                if (!$ok) {
                    $this->registerError($field, $metadata, 'numeric');
                }
                return $ok;

            case 'valid_email':
                $ok = (bool) filter_var((string) $value, FILTER_VALIDATE_EMAIL);
                if (!$ok) {
                    $this->registerError($field, $metadata, 'valid_email');
                }
                return $ok;

            case 'in_list':
                $choices = array_map('trim', explode(',', (string) $param));
                $ok = in_array((string) $value, $choices, true);
                if (!$ok) {
                    $this->registerError($field, $metadata, 'in_list');
                }
                return $ok;

            case 'greater_than':
                $ok = (float) $value > (float) $param;
                if (!$ok) {
                    $this->registerError($field, $metadata, 'greater_than', $param);
                }
                return $ok;

            case 'is_unique':
                $ok = $this->is_unique((string) $value, (string) $param);
                if (!$ok) {
                    $this->registerError($field, $metadata, 'is_unique');
                }
                return $ok;
        }

        return true;
    }

    protected function registerError(string $field, array &$metadata, string $message, ?string $param = null): void
    {
        if (isset($metadata['errors'][$message]) && is_string($metadata['errors'][$message]) && $metadata['errors'][$message] !== '') {
            $message = $metadata['errors'][$message];
        } else {
            $message = $this->resolveValidationMessage($message, $param);
        }

        $metadata['error'] = $message;
        $this->_error_array[$field] = $message;
    }

    protected function resolveValidationMessage(string $rule, ?string $param = null): string
    {
        if (function_exists('lang')) {
            // First try direct language key (e.g. authentication_error_invalid_reset_account).
            $translated = lang($rule);
            if (is_string($translated) && $translated !== '' && $translated !== $rule) {
                return $translated;
            }

            // Then try generic validation warning keys.
            $langKey = 'warning_' . $rule;
            $translated = lang($langKey);
            if (is_string($translated) && $translated !== '' && $translated !== $langKey) {
                return $translated;
            }
        }

        return match ($rule) {
            'required' => 'Ce champ est obligatoire.',
            'min_length' => 'Longueur minimale invalide' . ($param !== null ? ' (' . $param . ')' : '') . '.',
            'max_length' => 'Longueur maximale invalide' . ($param !== null ? ' (' . $param . ')' : '') . '.',
            'matches' => 'Les valeurs ne correspondent pas.',
            'numeric' => 'La valeur doit être numérique.',
            'valid_email' => 'Adresse e-mail invalide.',
            'in_list' => 'Valeur invalide.',
            'greater_than' => 'La valeur doit être supérieure' . ($param !== null ? ' à ' . $param : '') . '.',
            'is_unique' => 'Cette valeur existe déjà.',
            default => $rule,
        };
    }

    /**
     * @param array<string,mixed> $metadata
     */
    protected function extractFieldValue(array $metadata, array $data)
    {
        if ($metadata['is_array'] && !empty($metadata['keys'])) {
            $ref = $data;
            foreach ($metadata['keys'] as $k) {
                if (!is_array($ref) || !array_key_exists($k, $ref)) {
                    return null;
                }
                $ref = $ref[$k];
            }
            return $ref;
        }

        $field = $metadata['field'];
        if (array_key_exists($field, $data)) {
            return $data[$field];
        }

        if (str_ends_with($field, '[]')) {
            $base = substr($field, 0, -2);
            if (array_key_exists($base, $data)) {
                return $data[$base];
            }
        }

        return null;
    }

    /**
     * @return array{0:string,1:?string}
     */
    protected function parseRule(string $rule): array
    {
        if (preg_match('/^([a-z_]+)\[(.*)\]$/i', $rule, $m)) {
            return [$m[1], $m[2]];
        }

        return [$rule, null];
    }

    protected function is_unique(string $value, string $field): bool
    {
        if ($value === '' || $field === '') {
            return true;
        }

        [$tableField, $ignoreField, $ignoreValue] = array_pad(explode(',', $field), 3, null);
        [$table, $column] = array_pad(explode('.', (string) $tableField), 2, null);

        if (!$table || !$column || !class_exists(\Illuminate\Database\Capsule\Manager::class)) {
            return true;
        }

        $query = \Illuminate\Database\Capsule\Manager::table($table)->where($column, $value);
        if ($ignoreField !== null && $ignoreValue !== null) {
            $query->where($ignoreField, '!=', $ignoreValue);
        }

        return $query->count() === 0;
    }
}
