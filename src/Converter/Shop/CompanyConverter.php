<?php

namespace Nokaut\ApiKit\Converter\Shop;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Shop\Company;

class CompanyConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Company
     */
    public function convert(\stdClass $object)
    {
        $company = new Company();
        foreach ($object as $field => $value) {
            if (is_object($value) || is_array($value)) {
                $this->convertSubObject($company, $field, $value);
            } else {
                $company->set($field, $value);
            }
        }

        return $company;
    }

    /**
     * @param Company $company
     * @param $field
     * @param $value
     */
    protected function convertSubObject(Company $company, $field, $value)
    {
        switch ($field) {
            case 'address':
                $addressConverter = new AddressConverter();
                $company->setAddress($addressConverter->convert($value));
                break;
        }
    }
}