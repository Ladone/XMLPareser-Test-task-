<?php
/**
 * Created by PhpStorm.
 * User: Ladone
 * Date: 21.01.2018
 * Time: 1:19:39
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="currencies")
 */
class Currency
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="CurrencyCode", inversedBy="currency")
     * @ORM\JoinColumn(referencedColumnName="id", name="code", onDelete="CASCADE")
     */
    private $code;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

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
     * Set date
     *
     * @param \DateTime $date
     * @return Currency
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set value
     *
     * @param float $value
     * @return Currency
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set code
     *
     * @param \AppBundle\Entity\CurrencyCode $code
     * @return Currency
     */
    public function setCode(\AppBundle\Entity\CurrencyCode $code = null)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return \AppBundle\Entity\CurrencyCode 
     */
    public function getCode()
    {
        return $this->code;
    }
}
