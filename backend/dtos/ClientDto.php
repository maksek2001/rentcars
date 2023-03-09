<?php

namespace backend\dtos;

class ClientDto
{
    /** @var string */
    public $email;

    /** @var string */
    public $phone;

    /** @var string */
    public $fullname;

    /** @var string */
    public $birthDate;

    /** @var string */
    public $passportSerie;

    /** @var string */
    public $passportNumber;

    /** @var string */
    public $passportIssueDate;

    /** @var string */
    public $passportIssueOrganization;

    /** @var string */
    public $passportOrganizationCode;

    /** @var string */
    public $licenseSerie;

    /** @var string */
    public $licenseNumber;

    /** @var string */
    public $licenseIssueDate;

    /** @var string */
    public $licenseExpirationDate;

    public function __construct(array $array)
    {
        $this->email = $array['client_email'];
        $this->phone = $array['client_phone'];
        $this->fullname = $array['client_fullname'];
        $this->birthDate = $array['client_birth_date'];
        $this->passportSerie = $array['passport_serie'];
        $this->passportNumber = $array['passport_number'];
        $this->passportIssueDate = $array['passport_issue_date'];
        $this->passportIssueOrganization = $array['passport_issue_organization'];
        $this->passportOrganizationCode = $array['passport_organization_code'];
        $this->licenseSerie = $array['license_serie'];
        $this->licenseNumber = $array['license_number'];
        $this->licenseIssueDate = $array['license_issue_date'];
        $this->licenseExpirationDate = $array['license_expiration_date'];
    }
}
