<?php

namespace Wearesho\Bobra\Portmone\Direct;

use Wearesho\Bobra\Portmone\NotificationInterface;

/**
 * Class Payment
 * @package Wearesho\Bobra\Portmone\Direct
 */
abstract class Payment implements NotificationInterface, \JsonSerializable
{
    /** @var Entities\Company */
    protected $company;

    /** @var Entities\Bank */
    protected $bank;

    public function __construct(Entities\Company $company, Entities\Bank $bank)
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

    public function getCompany(): Entities\Company
    {
        return $this->company;
    }

    public function getBank(): Entities\Bank
    {
        return $this->bank;
    }
}
