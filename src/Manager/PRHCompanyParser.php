<?php

namespace App\Manager;

class PRHCompanyParser
{
    private const CONTACT_DETAILS_TYPE_WEBSITE = 'Website address';
    private const LANG_FI = 'FI';
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getName(): string
    {
        return $this->data['name'] ?? '';
    }

    public function getWebsiteAddress(): string
    {
        $website = '';
        if (isset($this->data['contactDetails'])) {
            foreach ($this->data['contactDetails'] as $contactDetail) {
                if ($contactDetail['type'] === self::CONTACT_DETAILS_TYPE_WEBSITE) {
                    $website = $contactDetail['value'];
                    break;
                }
            }
        }
        return $website;
    }

    public function getLatestAddress(): array
    {
        $address = [];
        if (count($this->data['addresses']) > 0) {
            $latest = end($this->data['addresses']);
            $address = [
                'street' => $latest['street'],
                'postCode' => $latest['postCode'],
                'city' => $latest['city'],
            ];
        }
        return $address;
    }

    public function getBusinessLine(): array
    {
        $businessLineData = [];
        if (isset($this->data['businessLines'])) {
            foreach ($this->data['businessLines'] as $businessLine) {
                if ($businessLine['language'] === self::LANG_FI) {
                    $businessLineData = [
                        'code' => $businessLine['code'],
                        'description' => $businessLine['name']
                    ];
                }
            }
        }
        return $businessLineData;
    }
}