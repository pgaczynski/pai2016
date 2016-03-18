<?php
/**
 * Created by PhpStorm.
 * User: Patryk
 * Date: 12.03.2016
 * Time: 17:05
 */

namespace ProductBundle\Entity;

use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * History
 *
 * @ORM\Table(name="historia")
 * @ORM\Entity()
 */
class Historia
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="amount", type="integer")
     * @Assert\NotBlank(message="To pole nie może być puste")
     * @Assert\Range(
     *     min = 1,
     *     minMessage="Minimalna ilość to {{ limit }}"
     * )
     */
    private $amount;

    /**
     *
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ManyToOne(targetEntity="ProductBundle\Entity\Product", inversedBy="historys")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

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
     * Set amount
     *
     * @param integer $amount
     *
     * @return Historia
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Historia
     */
    public function setDate()
    {
        $this->date = new \DateTime("now");

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
     * Set product
     *
     * @param \ProductBundle\Entity\Product $product
     *
     * @return Historia
     */
    public function setProduct(\ProductBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \ProductBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
