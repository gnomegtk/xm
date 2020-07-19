<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class SearchHistorical
{
    /**
     * @Assert\NotBlank
     *
     * @var string
     */
    protected $companySymbol;

    /**
     * @Assert\NotBlank
     * @Assert\Type("\DateTime")
     *
     * @var DateTime
     */
    protected $startDate;

    /**
     * @Assert\NotBlank
     * @Assert\Type("\DateTime")
     *
     * @var DateTime
     */
    protected $endDate;

    /**
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     *
     * @var string
     */
    protected $email;

    /**
     * @return string|null
     */
    public function getCompanySymbol(): ?string
    {
        return $this->companySymbol;
    }

    /**
     * @param string $companySymbol
     *
     * @return Search
     */
    public function setCompanySymbol(string $companySymbol): self
    {
        $this->companySymbol = $companySymbol;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getStartDate(): ?DateTime
    {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     *
     * @return Search
     */
    public function setStartDate(DateTime $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getEndDate(): ?DateTime
    {
        return $this->endDate;
    }

    /**
     * @param DateTime $endDate
     *
     * @return Search
     */
    public function setEndDate(DateTime $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Search
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->email;
    }
}