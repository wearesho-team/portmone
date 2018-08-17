<?php

namespace Wearesho\Bobra\Portmone\Notification;

use Wearesho\Bobra\Portmone\NotificationInterface;

/**
 * Class Payment
 * @package Wearesho\Bobra\Portmone\Notification
 */
abstract class Payment implements NotificationInterface,\JsonSerializable
{
    /** @var Entities\CompanyData */
    protected $company;

    /** @var Entities\BankData */
    protected $bank;

    public function __construct(Entities\CompanyData $company, Entities\BankData $bank)
    {
        $this->company = $company;
        $this->bank = $bank;
    }

    public function jsonSerialize(): array
    {
        return [
            'company' => $this->company->jsonSerialize(),
            'bank' => $this->bank->jsonSerialize(),
        ];
    }

    public function getPayee(): string
    {
        return $this->company->getCode();
    }

    public function getCompany(): Entities\CompanyData
    {
        return $this->company;
    }

    public function getBank(): Entities\BankData
    {
        return $this->bank;
    }
}
