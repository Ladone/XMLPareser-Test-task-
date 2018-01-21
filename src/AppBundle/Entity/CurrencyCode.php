<?php
/**
 * Created by PhpStorm.
 * User: Ladone
 * Date: 21.01.2018
 * Time: 1:41:06
 */

namespace AppBundle\Entity;
use AppBundle\Entity\Currency;
use Doctrine\ORM\Mapping AS ORM;

/**
 * Class CurrencyName
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table()
 */
class CurrencyCode
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="Currency", mappedBy="code")
     */
    private $currency;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->currency = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return CurrencyCode
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Add currency
     *
     * @param \AppBundle\Entity\Currency $currency
     * @return CurrencyCode
     */
    public function addCurrency(\AppBundle\Entity\Currency $currency)
    {
        $this->currency[] = $currency;

        return $this;
    }

    /**
     * Remove currency
     *
     * @param \AppBundle\Entity\Currency $currency
     */
    public function removeCurrency(\AppBundle\Entity\Currency $currency)
    {
        $this->currency->removeElement($currency);
    }

    /**
     * Get currency
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}
