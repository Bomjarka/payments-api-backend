<?php

declare(strict_types=1);

namespace App\Components\Payment\AwesomePayment;

use App\Components\Payment\PaymentInterface;
use App\Exceptions\UnknownPaymentStatusException;
use App\Models\Payment;
use App\Models\PaymentSystem;
use App\Models\User;
use Carbon\CarbonImmutable;

class AwesomePayment implements PaymentInterface
{
    protected int $merchantId;
    protected PaymentSystem $paymentSystem;
    protected int $externalPaymentId;
    protected int $userId;

    protected User $user;

    protected string $status;

    protected int $amount;
    protected int $amountPaid;
    protected CarbonImmutable $paidAt;

    protected array $data;
    protected const STATUS_NEW = 'new';
    protected const STATUS_PENDING = 'pending';
    protected const STATUS_COMPLETED = 'completed';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_REJECTED = 'rejected';
    public const STATUSES = [
        self::STATUS_NEW => Payment::STATUS_NEW,
        self::STATUS_PENDING => Payment::STATUS_PROCESSING,
        self::STATUS_COMPLETED => Payment::STATUS_COMPLETED,
        self::STATUS_EXPIRED => Payment::STATUS_EXPIRED,
        self::STATUS_REJECTED => Payment::STATUS_REJECTED,
    ];

    /**
     * @throws UnknownPaymentStatusException
     */
    public function __construct(array $paymentData)
    {
        $this->merchantId = (int) $paymentData['merchant_id'];
        $this->externalPaymentId = (int) $paymentData['payment_id'];

        //В реквесте нет user_id или другой привязки к пользователю
        $this->userId = 1;
        $this->user = User::find((int) 1);

        $this->status = (string) $paymentData['status'];
        $this->amount = (int) $paymentData['amount'];
        $this->amountPaid = (int) $paymentData['amount_paid'];
        $this->paidAt = CarbonImmutable::parse($paymentData['timestamp']);
        $this->data = $paymentData;
        $this->paymentSystem = PaymentSystem::find((int) $paymentData['merchant_id']);

        $this->mapStatus($this->status);
    }

    /**
     * @return int
     */
    public function getMerchantId(): int
    {
        return $this->merchantId;
    }

    /**
     * @return PaymentSystem
     */
    public function getPaymentSystem(): PaymentSystem
    {
        return $this->paymentSystem;
    }

    /**
     * @return int
     */
    public function getExternalExternalPaymentId(): int
    {
        return $this->externalPaymentId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getAmountPaid(): int
    {
        return $this->amountPaid;
    }

    /**
     * @return CarbonImmutable
     */
    public function getPaidAt(): CarbonImmutable
    {
        return $this->paidAt;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @throws UnknownPaymentStatusException
     */
    private function mapStatus(string $status): void
    {
        if (!isset(self::STATUSES[$status])) {
            throw new UnknownPaymentStatusException('No status: ' . $status);
        }

        $this->status = self::STATUSES[$status];
    }
}
