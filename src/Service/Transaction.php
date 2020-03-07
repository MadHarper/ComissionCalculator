<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service;

use DateTimeImmutable;
use DomainException;

class Transaction
{
    const CASH_IN_OPERATION_TYPE    = 'cash_in';
    const CASH_OUT_OPERATION_TYPE   = 'cash_out';

    const LEGAL_PERSON_TYPE = 'legal';
    const NATURAL_PERSON_TYPE = 'natural';

    /**
     * @var DateTimeImmutable
     */
    private $date;
    /**
     * @var int
     */
    private $userId;
    /**
     * @var string
     */
    private $userType;
    /**
     * @var string
     */
    private $operationType;
    /**
     * @var Money
     */
    private $money;
    /**
     * @var Money
     */
    private $fee;
    /**
     * @var Money
     */
    private $euro;

    public function __construct(
        DateTimeImmutable $date,
        int $userId,
        string $userType,
        string $operationType,
        Money $money,
        Money $euro
    )
    {
        $this->date = $date;
        $this->userId = $userId;

        if (self::CASH_IN_OPERATION_TYPE !== $operationType && self::CASH_OUT_OPERATION_TYPE !== $operationType) {
            throw new DomainException('Illegal operation type');
        }

        $this->operationType = $operationType;

        if (self::LEGAL_PERSON_TYPE !== $userType && self::NATURAL_PERSON_TYPE !== $userType) {
            throw new DomainException('Illegal person type type');
        }

        $this->userType = $userType;
        $this->money = $money;
        $this->euro = $euro;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUserType(): string
    {
        return $this->userType;
    }

    public function getOperationType(): string
    {
        return $this->operationType;
    }

    public function getMoney(): Money
    {
        return $this->money;
    }

    public function getEuro(): Money
    {
        return $this->euro;
    }

    public function getStartOfWeek(): DateTimeImmutable
    {
        return $this->date->modify('Monday this week');
    }

    public function getStartOfWeekTimestamp(): int
    {
        return $this->getStartOfWeek()->getTimestamp();
    }

    public function setFee(Money $fee)
    {
        $this->fee = $fee;
    }

    public function getFee(): Money
    {
        return $this->fee;
    }

    public function hasCachOutType(): bool
    {
        return $this->operationType === self::CASH_OUT_OPERATION_TYPE;
    }

    public function hasCachInType(): bool
    {
        return $this->operationType === self::CASH_IN_OPERATION_TYPE;
    }

    public function isNaturalPerson(): bool
    {
        return $this->userType === self::NATURAL_PERSON_TYPE;
    }
}