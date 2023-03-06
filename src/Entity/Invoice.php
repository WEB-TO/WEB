<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvoiceRepository::class)
 */
class Invoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    public function __toString() 
    {
       return (String)$this->id; 
    }

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity=Staff::class, inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $staff;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\OneToMany(targetEntity=InvoiceProduct::class, mappedBy="invoice", orphanRemoval=true)
     */
    private $invoiceProducts;

    public function __construct()
    {
        $this->invoiceProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): self
    {
        $this->staff = $staff;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection<int, InvoiceProduct>
     */
    public function getInvoiceProducts(): Collection
    {
        return $this->invoiceProducts;
    }

    public function addInvoiceProduct(InvoiceProduct $invoiceProduct): self
    {
        if (!$this->invoiceProducts->contains($invoiceProduct)) {
            $this->invoiceProducts[] = $invoiceProduct;
            $invoiceProduct->setInvoice($this);
        }

        return $this;
    }

    public function removeInvoiceProduct(InvoiceProduct $invoiceProduct): self
    {
        if ($this->invoiceProducts->removeElement($invoiceProduct)) {
            // set the owning side to null (unless already changed)
            if ($invoiceProduct->getInvoice() === $this) {
                $invoiceProduct->setInvoice(null);
            }
        }

        return $this;
    }

    

}
