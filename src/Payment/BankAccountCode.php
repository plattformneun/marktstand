<?php

namespace Marktstand\Payment;

use Marktstand\Exceptions\InvalidArgumentException;

class BankAccountCode
{
    const FORMATS = [
        'AT' => '[A-Z0-9]{4}AT[A-Z0-9]{2}([A-Z0-9]{3})?',
        'BE' => '[A-Z0-9]{4}BE[A-Z0-9]{2}([A-Z0-9]{3})?',
        'BG' => '[A-Z0-9]{4}BG[A-Z0-9]{2}([A-Z0-9]{3})?',
        'CY' => '[A-Z0-9]{4}CY[A-Z0-9]{2}([A-Z0-9]{3})?',
        'CZ' => '[A-Z0-9]{4}CZ[A-Z0-9]{2}([A-Z0-9]{3})?',
        'DE' => '[A-Z0-9]{4}DE[A-Z0-9]{2}([A-Z0-9]{3})?',
        'DK' => '[A-Z0-9]{4}DK[A-Z0-9]{2}([A-Z0-9]{3})?',
        'EE' => '[A-Z0-9]{4}EE[A-Z0-9]{2}([A-Z0-9]{3})?',
        'GR' => '[A-Z0-9]{4}GR[A-Z0-9]{2}([A-Z0-9]{3})?',
        'ES' => '[A-Z0-9]{4}ES[A-Z0-9]{2}([A-Z0-9]{3})?',
        'FI' => '[A-Z0-9]{4}FI[A-Z0-9]{2}([A-Z0-9]{3})?',
        'FR' => '[A-Z0-9]{4}FR[A-Z0-9]{2}([A-Z0-9]{3})?',
        'GB' => '[A-Z0-9]{4}GB[A-Z0-9]{2}([A-Z0-9]{3})?',
        'HR' => '[A-Z0-9]{4}HR[A-Z0-9]{2}([A-Z0-9]{3})?',
        'HU' => '[A-Z0-9]{4}HU[A-Z0-9]{2}([A-Z0-9]{3})?',
        'IE' => '[A-Z0-9]{4}IE[A-Z0-9]{2}([A-Z0-9]{3})?',
        'IT' => '[A-Z0-9]{4}IT[A-Z0-9]{2}([A-Z0-9]{3})?',
        'LT' => '[A-Z0-9]{4}LT[A-Z0-9]{2}([A-Z0-9]{3})?',
        'LU' => '[A-Z0-9]{4}LU[A-Z0-9]{2}([A-Z0-9]{3})?',
        'LV' => '[A-Z0-9]{4}LV[A-Z0-9]{2}([A-Z0-9]{3})?',
        'MT' => '[A-Z0-9]{4}MT[A-Z0-9]{2}([A-Z0-9]{3})?',
        'NL' => '[A-Z0-9]{4}NL[A-Z0-9]{2}([A-Z0-9]{3})?',
        'PL' => '[A-Z0-9]{4}PL[A-Z0-9]{2}([A-Z0-9]{3})?',
        'PT' => '[A-Z0-9]{4}PT[A-Z0-9]{2}([A-Z0-9]{3})?',
        'RO' => '[A-Z0-9]{4}RO[A-Z0-9]{2}([A-Z0-9]{3})?',
        'SE' => '[A-Z0-9]{4}SE[A-Z0-9]{2}([A-Z0-9]{3})?',
        'SI' => '[A-Z0-9]{4}SI[A-Z0-9]{2}([A-Z0-9]{3})?',
        'SK' => '[A-Z0-9]{4}SK[A-Z0-9]{2}([A-Z0-9]{3})?',
    ];

    /**
     * @var string
     */
    private $swift;

    /**
     * Create a new bank account code instance.
     */
    public function __construct(string $swift)
    {
        $this->swift = $this->canonicalize($swift);

        $this->validate();
    }

    /**
     * Get the country code.
     *
     * @return string
     */
    public function countryCode()
    {
        return substr($this->swift, 4, 2);
    }

    /**
     * Get the swift.
     *
     * @return string
     */
    public function swift()
    {
        return $this->swift;
    }

    /**
     * Canonicalize the given value.
     *
     * @param  string $iban
     * @return string
     */
    protected function canonicalize($swift)
    {
        return str_replace(' ', '', strtoupper($swift));
    }

    /**
     * Get the matching regular expression format.
     *
     * @return string
     */
    protected function format()
    {
        return self::FORMATS[$this->countryCode()];
    }

    /**
     * Validate the given value.
     *
     * @return void
     */
    protected function validate()
    {
        if (! ctype_alnum($this->swift)) {
            throw new InvalidArgumentException('Invalid Characters');
        }

        if (! array_key_exists($this->countryCode(), self::FORMATS)) {
            throw new InvalidArgumentException('Invalid Country Code');
        }

        if (! preg_match('/^'.$this->format().'$/', $this->swift)) {
            throw new InvalidArgumentException('Invalid Format');
        }
    }

    /**
     * Cast the object to an reinitialisable string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->swift();
    }
}
